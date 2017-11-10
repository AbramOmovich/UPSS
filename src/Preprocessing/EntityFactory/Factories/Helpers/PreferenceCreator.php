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

    private function findProperties($properties, $property_prefix = '')
    {
        foreach ($properties as $propertyName => $value) {
            if ($property_prefix){
                $propertyName = $property_prefix . ':' . $propertyName;
            }

            if (!isset($this->preferences[$propertyName]) && !is_null($value)) {
                if (is_array($value)) {
                    $this->findProperties($value, $propertyName);
                }else {
                    $this->preferences[$propertyName]['weight'] = 0.5;
                    if (is_numeric($value)) {
                        $this->preferences[$propertyName]['direction'] = 1;
                    }

                    if (is_string($value)) {
                        $this->preferences[$propertyName]['match'] = '';
                    }
                }
            }
        }
    }
}