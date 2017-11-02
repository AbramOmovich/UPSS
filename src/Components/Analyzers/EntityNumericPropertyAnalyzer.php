<?php

namespace UPSS\Components\Analyzers;

use UPSS\Preprocessing\EntityCollection\ICollection;

class EntityNumericPropertyAnalyzer implements IAnalyzer
{

    private const NESTING_COEFFICIENT = 0.8;

    private $weights = [];

    private $preferences;

    private $entities;
    private $amountOfEntities;

    private $extrema;

    public function analyze(ICollection $data): array
    {
        $this->preferences = $data->getPreferences();
        $this->entities = $data->getEntities();
        $this->amountOfEntities = count($this->entities);

        $this->findExtrema();
        $this->analyzeWeights();
        $this->sumWeights();

        return ['numeric_weights' => $this->weights];
    }

    private function sumWeights()
    {
        foreach ($this->weights as &$entity){
            foreach ($entity as $property => $value){
                $entity[$property] = array_sum($value);

                //applying property weight
                $entity[$property] = $entity[$property] * $this->preferences[$property]['weight'];
            }
            $entity = array_sum($entity);
        }
    }

    private function analyzeWeights()
    {
        for ($index = 0; $index < $this->amountOfEntities; $index++) {
            $properties = $this->entities[$index]->getProperties();
            $this->getPropertiesWeights($properties, $index);
        }
    }

    private function getPropertiesWeights($properties, $entityIndex, $nesting = 0)
    {
        foreach ($properties as $propertyName => $propertyValue){
            if (isset($this->preferences[$propertyName]) && !is_array($propertyValue)){

                if (is_numeric($propertyValue) && isset($this->preferences[$propertyName]['direction'])){

                    $propertyWeight = 0;
                    if ($this->preferences[$propertyName]['direction'] == 1) {
                        $propertyWeight += $properties[$propertyName] / $this->extrema[$propertyName];
                    } elseif ($this->preferences[$propertyName]['direction'] == 0) {
                        $propertyWeight += $this->extrema[$propertyName] / $properties[$propertyName];
                    }

                    if($nesting){
                        $propertyWeight *= (self::NESTING_COEFFICIENT / $nesting);
                    }

                    $this->weights[$entityIndex][$propertyName][$nesting] = $propertyWeight;
                }
            }
            if (is_array($propertyValue) && !empty($propertyValue)){
                $this->getPropertiesWeights($propertyValue, $entityIndex, $nesting + 1);
            }
        }
    }

    private function findExtrema()
    {
        foreach ($this->entities as $entity) {
            $properties = $entity->getProperties();
            $this->getExtrema($properties);
        }
    }

    private function getExtrema($properties)
    {
        foreach ($properties as $propertyName => $propertyValue){
            //if it's user's preferred property
            if (isset($this->preferences[$propertyName]) && !is_array($propertyValue)){

                if (is_numeric($propertyValue) && isset($this->preferences[$propertyName]['direction'])){
                    if (isset($this->extrema[$propertyName])) {

                        //extrema for maximization
                        if ($this->preferences[$propertyName]['direction'] == 1 && $propertyValue > $this->extrema[$propertyName]) {
                            $this->extrema[$propertyName] = $propertyValue;

                        //extrema for minimization
                        } elseif ($this->preferences[$propertyName]['direction'] == 0 && $propertyValue < $this->extrema[$propertyName]) {
                            $this->extrema[$propertyName] = $propertyValue;
                        }
                    } else {
                        $this->extrema[$propertyName] = $propertyValue;
                    }
                }
            //or it's array
            } elseif (is_array($propertyValue) && !empty($propertyValue)){
                $this->getExtrema($propertyValue);
            }
        }
    }
}