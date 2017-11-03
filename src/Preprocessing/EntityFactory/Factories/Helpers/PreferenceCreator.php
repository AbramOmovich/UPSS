<?php

namespace UPSS\Preprocessing\EntityFactory\Factories\Helpers;

trait PreferenceCreator
{
    private $entities = [];
    private $preferences = [];

    public function createPreferences(): array
    {
        foreach ($this->entities as $entity) {
            $properties = $entity->getProperties();
            $this->findProperties($properties);
        }

        return $this->preferences;
    }

    public function findProperties($properties)
    {
        foreach ($properties as $property => $value) {
            if (!isset($this->preferences[$property])) {
                $this->preferences[$property]['weight'] = 0.5;
                if (is_numeric($value)) {
                    $this->preferences[$property]['direction'] = 1;

                } elseif (is_array($value)) {
                    $this->findProperties($value);
                }

                if (is_string($value)) {
                    $this->preferences[$property]['match'] = '';
                }
            }
        }
    }
}