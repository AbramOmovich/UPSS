<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;

use UPSS\Preprocessing\Entities\IEntity;
use UPSS\Preprocessing\Entities\JsonEntity;
use UPSS\Preprocessing\EntityFactory\EntityCreationException;

class JsonEntityFactory implements IEntityFactory
{
    private $data;
    private $offset;

    public function createEntity() : IEntity
    {
        if ($this->hasObjects() && isset($this->offset)){
            if (isset($this->data['objects'][$this->offset])) {
                $entity = new JsonEntity();

                $reflectionClass = new \ReflectionClass(JsonEntity::class);
                $reflectionProperty = $reflectionClass->getProperty('properties');
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($entity, $this->data['objects'][$this->offset]);

                $this->offset++;

                return $entity;
            }
        }
        throw new \Exception("Unable to create entity");
    }

    public function setInputData($data)
    {
        $this->data = json_decode($data, true);
        $this->offset = 0;
    }

    public function createPreferences() : array
    {
        if (isset($this->data['preferences']) && is_array($this->data['preferences'])){
            return $this->data['preferences'];
        }

        throw new EntityCreationException("Unable to create preferences");
    }

    public function hasMoreObjects() : bool
    {
        return ($this->offset < count($this->data['objects']));
    }

    public function hasObjects() : bool
    {
        return (isset($this->data['objects']));
    }
}
