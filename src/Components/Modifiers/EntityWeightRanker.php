<?php

namespace UPSS\Components\Modifiers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

class EntityWeightRanker implements IModifier
{
    private $weights;
    private $collection;

    public function modify(IEntityCollection $data, array &$analytics = [])
    {
        if (isset($analytics['scalar_weights'])){
            $this->collection = $data;
            $this->weights = $analytics['scalar_weights'];
            $this->rangeCollection();
        }
    }

    private function rangeCollection()
    {
        $entities = $this->collection->getEntities();
        $this->collection->clearEntities();
        asort($this->weights);
        $rangedEntities = [];

        foreach ($this->weights as $index => $weight){
            $rangedEntities []= $entities[$index];
        }

        foreach ($rangedEntities as $entity){
            $this->collection->addToCollection($entity);
        }
    }

}