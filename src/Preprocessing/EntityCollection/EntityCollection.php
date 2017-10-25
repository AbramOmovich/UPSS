<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

class EntityCollection implements IEntityCollection
{
    private $entities = [];
    private $preferences;

    public function getObjects() : array
    {
        return $this->entities;
    }

    public function getPreferences()
    {
        return $this->preferences;
    }

    public function addToCollection(IEntity $entity)
    {
        $this->entities []= $entity;
    }

    public function setPreferences(array $preferences)
    {
        $this->preferences = $preferences;
    }

    public function removeFromCollection($index = '')
    {
        if (isset($this->entities[$index])){
            unset($this->entities[$index]);
        } else {
            throw new \Exception("Offset {$index} not exists in collection");
        }
    }
}
