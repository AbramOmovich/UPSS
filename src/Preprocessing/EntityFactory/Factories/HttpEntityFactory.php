<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;


use UPSS\Preprocessing\Entities\HttpEntity;
use UPSS\Preprocessing\Entities\IEntity;

class HttpEntityFactory implements IEntityFactory
{
    use Helpers\PreferenceCreator;

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
        if (is_array($data) && !empty($data)) {
            $this->offset = 0;
            $this->data = array_values($data);
            $this->length = count($this->data);
        } else {
            throw new \Exception("Unappropriated data provided");
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