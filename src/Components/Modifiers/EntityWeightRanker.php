<?php

namespace UPSS\Components\Modifiers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

class EntityWeightRanker implements IModifier
{
    private $weights;
    private $collection;

    public function modify(IEntityCollection $data, array &$analytics = [])
    {
        if (!empty($analytics)){
            $this->collection = $data;
            $this->weights = array_values($analytics)[0];
            $this->rangeCollection();
        }
    }

    private function rangeCollection()
    {
        $entities = $this->collection->getEntities();
        $this->collection->clearEntities();

        //The more weight entity has the more it's preferable
        arsort($this->weights);
        $rangedEntities = [];

        foreach ($this->weights as $index => $weight){
            $rangedEntities []= $entities[$index];
            unset($entities[$index]);
        }
        if (!empty($entities)){
            foreach ($entities as $index => $entity) {
                $rangedEntities []= $entity;
                unset($entities[$index]);
            }
        }

        foreach ($rangedEntities as $entity){
            $this->collection->addEntity($entity);
        }
    }

}