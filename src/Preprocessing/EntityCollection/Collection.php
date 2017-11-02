<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

class Collection implements ICollection
{
    private $entities = [];
    private $preferences = [];

    public function getEntities(): array
    {
        return $this->entities;
    }

    public function getPreferences(): array
    {
        return $this->preferences;
    }

    public function addToCollection(IEntity $entity)
    {
        $this->entities [] = $entity;
    }

    public function setPreferences(array $preferences)
    {
        $this->preferences = $preferences;
    }

    public function removeFromCollection($index = '')
    {
        if (isset($this->entities[$index])) {
            unset($this->entities[$index]);
        } else {
            throw new \Exception("Offset {$index} not exists in collection");
        }
    }


    public function getAsArray(): array
    {
        $output = [];
        $output['preferences'] = $this->preferences;
        $output['objects'] = [];
        foreach ($this->entities as $entity) {
            $output['objects'][] = $entity->getProperties();
        }

        return $output;
    }

    public function clearEntities()
    {
        $this->entities = [];
    }

    public function hasEntities(): bool
    {
        return (isset($this->entities) && !empty($this->entities));
    }

    public function hasPreferences(): bool
    {
        return (isset($this->preferences) && !empty($this->preferences));
    }
}
