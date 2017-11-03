<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

class PreferenceCollection implements ICollection, IPreferenceCollection
{

    private $entities_id = '';
    private $preferences = [];

    public function getEntities(): array
    {
       return [];
    }

    public function getPreferences(): array
    {
        return $this->preferences;
    }

    public function addEntity(IEntity $entity) {}

    public function setPreferences(array $preferences)
    {
        $this->preferences = $preferences;
    }

    public function removeEntityFromCollection($index)
    {
        if (isset($this->preferences[$index])){
            unset($this->preferences[$index]);
        } else throw new \Exception("offset {$index} not exists");
    }



    public function getAsArray(): array
    {
        return [
            'entities_id' => $this->entities_id,
            'preferences' => $this->preferences
        ];
    }

    public function hasEntities(): bool
    {
        return false;
    }

    public function hasPreferences(): bool
    {
        return (isset($this->preferences) && !empty($this->preferences));
    }

    public function setEntitiesId(string $id)
    {
        $this->entities_id = $id;
    }

    public function getEntitiesId() : string
    {
        return $this->entities_id;
    }
}