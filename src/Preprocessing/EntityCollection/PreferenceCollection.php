<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

class PreferenceCollection implements IPreferenceCollection
{

    private $entities_id = '';
    private $preferences = [];

    public function getPreferences(): array
    {
        return $this->preferences;
    }

    public function setPreferences(array $preferences)
    {
        $this->preferences = $preferences;
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