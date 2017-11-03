<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;

use UPSS\Preprocessing\Entities\IEntity;
use UPSS\Preprocessing\Entities\JsonEntity;
use UPSS\Preprocessing\EntityFactory\EntityCreationException;

class JsonEntityFactory implements IEntityFactory
{
    use Helpers\PreferenceCreator;

    private $data;
    private $offset;
    private $entities = [];
    private $amount;

    public function createEntity() : IEntity
    {
        if ($this->hasObjects() && isset($this->offset)){
            if (isset($this->data[$this->offset])) {
                $entity = new JsonEntity();

                $reflectionClass = new \ReflectionClass(JsonEntity::class);
                $reflectionProperty = $reflectionClass->getProperty('properties');
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($entity, $this->data[$this->offset]);

                $this->entities[$this->offset] = $entity;

                $this->offset++;
                return $entity;
            }
        }
        throw new \Exception("Unable to create entity");
    }

    public function setInputData($data)
    {
        $data = json_decode($data, true);
        if (is_array($data) && !empty($data)){
            $this->data = array_values($data);
            $this->offset = 0;
            unset($this->amount);
        } else throw new \Exception("Unappropriated json data provided");
    }

    public function hasMoreObjects() : bool
    {
        if (!isset($this->amount)){
            $this->amount = count($this->data);
        }
        return ($this->offset < $this->amount);
    }

    public function hasObjects() : bool
    {
        return (isset($this->data) && !empty($this->data));
    }
}
