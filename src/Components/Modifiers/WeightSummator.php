<?php

namespace UPSS\Components\Modifiers;

use UPSS\Preprocessing\EntityCollection\ICollection;

class WeightSummator implements IModifier
{

    private $results;

    public function modify(ICollection $data, array &$analytics = [])
    {
        if (!empty($analytics)){
            $this->results = &$analytics;
            $this->sumWeights();
        }
    }

    private function sumWeights()
    {
        $summedWeights = [];
        foreach ($this->results as $entityWeights){
            foreach ($entityWeights as $entityIndex => $weight){
                if (!isset($summedWeights[$entityIndex])){
                    $summedWeights[$entityIndex] = $weight;
                } else {
                    $summedWeights[$entityIndex] += $weight;
                }
            }
        }
        $this->results = [ $summedWeights ];
    }
}