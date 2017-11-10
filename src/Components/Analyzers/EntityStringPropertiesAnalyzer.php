<?php

namespace UPSS\Components\Analyzers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

class EntityStringPropertiesAnalyzer implements IAnalyzer
{
    private $weights = [];
    private $entities;
    private $preferences;

    private const FULL_MATCH_PATTERN = "@\b{match}\b@u";
    private const BEGINNING_PATTERN = "@\b{match}[\w-]+\b@u";


    public function analyze(IEntityCollection $data) : array
    {
        $this->entities = $data->getEntities();
        $this->preferences = $data->getPreferences();

        $this->findStringPreferences();
        if (!empty($this->preferences)){
            $this->analyzeMatches();
            $this->applyPreferenceWeights();
        }

        return ['match_weights' => $this->weights];
    }

    private function applyPreferenceWeights()
    {
        foreach ($this->weights as $index => $weights){
            foreach ($weights as $property => $value){
                $weights[$property] = $value * $this->preferences[$property]['weight'];
            }
            $this->weights[$index] = array_sum($weights);
        }
    }

    private function findStringPreferences()
    {
        $stringPreferences = [];
        foreach ($this->preferences as $prefName => $prefSettings){
            if (isset($prefSettings['match'])){
                $stringPreferences[$prefName] = $prefSettings;
            }
        }
        $this->preferences = $stringPreferences;
    }

    private function analyzeMatches()
    {
        foreach ($this->entities as $index => $entity){
            $properties = $entity->getProperties();
            $this->analyzeProperties($properties, $index);
        }
    }

    private function analyzeProperties($properties, $entityIndex, $property_prefix = '')
    {
        foreach ($properties as $propertyName => $propertyValue){
            if ($property_prefix){
                $propertyName = $property_prefix . ':' . $propertyName;
            }

            if (is_array($propertyValue)){
                $this->analyzeProperties($propertyValue, $entityIndex, $propertyName);

                //if property has matching preference
            } elseif (isset($this->preferences[$propertyName]['match'])
                && (is_string($propertyValue) || is_numeric($propertyValue)) ){
                $match = $this->preferences[$propertyName]['match'];

                //if full word matched weight is increased in 1
                if (preg_match(str_replace('{match}', $match, self::FULL_MATCH_PATTERN), $propertyValue)){
                    if (!isset($this->weights[$entityIndex][$propertyName])){
                        $this->weights[$entityIndex][$propertyName] = 1;
                    } else {
                        $this->weights[$entityIndex][$propertyName]++;
                    }

                //if matched only word beginning
                } elseif (preg_match(
                    str_replace('{match}', $match, self::BEGINNING_PATTERN),
                    $propertyValue,
                    $matches)) {
                    $word = $matches[0];

                    //calculating weight depending on amount of letters matched
                    $weight = mb_strlen($match) / mb_strlen($word);

                    if (!isset($this->weights[$entityIndex][$propertyName])){
                        $this->weights[$entityIndex][$propertyName] = $weight;
                    } else {
                        $this->weights[$entityIndex][$propertyName] += $weight;
                    }
                }
            }
        }
    }
}