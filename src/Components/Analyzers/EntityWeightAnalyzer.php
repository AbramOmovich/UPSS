<?php

namespace UPSS\Components\Analyzers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

class EntityWeightAnalyzer implements IAnalyzer
{
    private $weights = [];
    private $preferences;
    private $entities;
    private $extrema;

    public function analyze(IEntityCollection $data) : array
    {
        $this->preferences = $data->getPreferences();
        $this->entities = $data->getEntities();

        $this->findExtrema();
        $this->analyzeWeights();
        return ['weights' => $this->weights];
    }

    private function analyzeWeights()
    {
        foreach ($this->entities as $entity){
            $entityWeight = 0;
            $properties = $entity->getProperties();
            foreach ($this->preferences as $preference => $settings){
                if (isset($properties[$preference])){
                    $weight = 0;
                    if ($settings['direction'] == 1){
                        $weight += $properties[$preference] / $this->extrema[$preference];
                    } elseif ($settings['direction'] == 0){
                        $weight += $this->extrema[$preference] / $properties[$preference];
                    }
                    $weight = $settings['weight'] / $weight;
                    $entityWeight += $weight;
                }
            }
            $this->weights[] = $entityWeight;
        }
    }

    private function findExtrema()
    {
       foreach ($this->entities as $entity){
           $properties = $entity->getProperties();
           foreach ($this->preferences as $preference => $settings){
               if (isset($properties[$preference])){
                   if (isset($this->extrema[$preference])){
                       if ($settings['direction'] == 1 && $properties[$preference] > $this->extrema[$preference]){
                           $this->extrema[$preference] = $properties[$preference];
                       } elseif ($settings['direction'] == 0 && $properties[$preference] < $this->extrema[$preference]){
                           $this->extrema[$preference] = $properties[$preference];
                       }
                   } else {
                       $this->extrema[$preference] = $properties[$preference];
                   }
               }
           }
       }
    }
}