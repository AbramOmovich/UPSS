<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;


use UPSS\Preprocessing\Entities\HttpEntity;
use UPSS\Preprocessing\Entities\IEntity;

class HttpEntityFactory implements IEntityFactory
{
    private $data;
    private $length;
    private $offset;
    private const UNABLE_TO_CREATE = 'Unable to create entity. Offset {offset} not exists';
    private const PREFERENCES_NOT_EXISTS = 'Unable to create preferences.';

    public function createEntity() : IEntity
    {
        if ($this->hasObjects() && isset($this->offset)){
            if (isset($this->data['objects'][$this->offset])) {
                $entity = new HttpEntity();

                $reflectionClass = new \ReflectionClass('HttpEntity');
                $reflectionProperty = $reflectionClass->getProperty('properties');
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($entity, $this->data['objects'][$this->offset]);

                $this->offset++;

                return $entity;
            }
        }
        throw new \Exception(str_replace('{offset}' , $this->offset, self::UNABLE_TO_CREATE));
    }

    public function setInputData($data)
    {
        $this->offset = 0;
        $this->data = $data;
        $this->length = count($this->data['objects']);
    }


    public function createPreferences(): array
    {
        if (isset($this->data['preferences'])) {
            return $this->data['preferences'];
        }
        throw new \Exception(self::PREFERENCES_NOT_EXISTS);
    }

    public function hasMoreObjects(): bool
    {
        return ($this->offset < $this->length);
    }

    public function hasObjects(): bool
    {
        return (isset($this->data['objects']));
    }
}