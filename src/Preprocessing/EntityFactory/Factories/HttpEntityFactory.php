<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;


use UPSS\Preprocessing\Entities\HttpEntity;
use UPSS\Preprocessing\Entities\IEntity;

class HttpEntityFactory implements IEntityFactory
{

    private $entities = [];
    private $preferences = [];

    private $data;

    private $length;

    private $offset = '';

    private const UNABLE_TO_CREATE = 'Unable to create entity. Offset {offset} not exists';

    private const PREFERENCES_NOT_EXISTS = 'Unable to create preferences.';

    public function createEntity(): IEntity
    {
        if ($this->hasObjects() && isset($this->offset)) {
            if (isset($this->data[$this->offset])) {
                $entity = new HttpEntity();

                $reflectionClass = new \ReflectionClass(HttpEntity::class);
                $reflectionProperty = $reflectionClass->getProperty('properties');
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($entity,
                    $this->data[$this->offset]);

                $this->offset++;

                $this->entities [] = $entity;

                return $entity;
            }
        }
        throw new \Exception(str_replace('{offset}', $this->offset,
            self::UNABLE_TO_CREATE));
    }

    public function setInputData($data)
    {
        if (is_array($data)) {
            $this->offset = 0;
            $this->data = array_values($data);
            $this->length = count($this->data);
        } else throw new \Exception("Un appropriate data provided");
    }


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
                if (is_numeric($value)) {
                    $this->preferences[$property] = [
                        'direction' => 1,
                        'weight' => 0.5
                    ];
                } elseif (is_array($value)) {
                    $this->findProperties($value);
                }

                if (is_string($value)) {
                    $this->preferences[$property]['match'] = '';
                }
            }
        }
    }

    public function hasMoreObjects(): bool
    {
        return ($this->offset < $this->length);
    }

    public function hasObjects(): bool
    {
        return (isset($this->data) && $this->length != 0);
    }
}