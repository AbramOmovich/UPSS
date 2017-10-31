<?php

namespace UPSS\Components\Analyzers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

class EntityScalarWeightAnalyzer implements IAnalyzer
{

    private const MAX_WEIGHT = 40000;
    private const NESTING_COEFICENT = 0.8;

    private $weights = [];

    private $preferences;

    private $entities;
    private $amountOfEntities;

    private $extrema;

    public function analyze(IEntityCollection $data): array
    {
        $this->preferences = $data->getPreferences();
        $this->entities = $data->getEntities();
        $this->amountOfEntities = count($this->entities);

        $this->findExtrema();
        $this->analyzeWeights();

        return ['scalar_weights' => $this->weights];
    }

    private function analyzeWeights()
    {
        for ($index = 0; $index < $this->amountOfEntities; $index++) {
            $properties = $this->entities[$index]->getProperties();
            $this->getEntityWeight($properties, $index);
        }
    }

    private function getEntityWeight($properties, $entityIndex, $nesting = 0, $entityWeight = self::MAX_WEIGHT)
    {
        foreach ($properties as $propertyName => $propertyValue){
            if (isset($this->preferences[$propertyName]) && !is_array($propertyValue)){

                if (is_numeric($propertyValue)){
                    if ($entityWeight === self::MAX_WEIGHT){
                        $entityWeight = 0;
                    }

                    $propertyWeight = 0;
                    if ($this->preferences[$propertyName]['direction'] == 1) {
                        $propertyWeight += $properties[$propertyName] / $this->extrema[$propertyName];
                    } elseif ($this->preferences[$propertyName]['direction'] == 0) {
                        $propertyWeight += $this->extrema[$propertyWeight] / $properties[$propertyName];
                    }
                    //$propertyWeight = $this->preferences[$propertyName]['weight'] / $propertyWeight;
                    if($nesting){
                        $propertyWeight *= (self::NESTING_COEFICENT / $nesting);
                    }

//                    if (isset($this->weights[$entityIndex][$propertyName][$nesting - 1])){
//                        $propertyWeight *= $this->weights[$entityIndex][$propertyName][$nesting - 1];
//                    }
                    $this->weights[$entityIndex][$propertyName][$nesting] = $propertyWeight;
                }
            }
            if (is_array($propertyValue) && !empty($propertyValue)){
                $nesting++;
                $this->getEntityWeight($propertyValue, $entityIndex, $nesting);
            }
        }


        /*foreach ($properties as $propertyName => $propertyValue){
            //if it's user's preferred property

            //or it's array
            } elseif (is_array($propertyValue) && !empty($propertyValue)){
                $subWeight = $this->getEntityWeight($propertyValue);
                if ($subWeight !== self::MAX_WEIGHT){

                }
            }
        }*/
        return $entityWeight;
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
            if (isset($this->preferences[$propertyName])){

                if (is_numeric($propertyValue)){
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