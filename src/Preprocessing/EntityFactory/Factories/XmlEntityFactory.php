<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;

use UPSS\Preprocessing\Entities\IEntity;
use UPSS\Preprocessing\Entities\XmlEntity;

class XmlEntityFactory implements IEntityFactory
{
    private const XML_INVALID = "XML data supplied is invalid";

    private $data;
    private $objects;
    private $preferences;
    private $offset;

    public function createEntity() : IEntity
    {
        $entity = new XmlEntity();
        if ((isset($this->objects[$this->offset])) && ($this->objects[$this->offset] instanceof \SimpleXMLElement)){
            $reflectionClass = new \ReflectionClass(XmlEntity::class);
            $reflectionProperty = $reflectionClass->getProperty('node');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($entity, $this->objects[$this->offset]);

            $this->offset++;

            return $entity;
        }
        throw new \Exception(self::XML_INVALID);
    }

    public function setInputData($data)
    {
        $this->data = simplexml_load_string($data);
        if ($this->hasObjects() && $this->hasPreferences()){
            foreach ($this->data->objects->children() as $object){
                $this->objects []= $object;
            }

            $this->preferences = $this->data->preferences->children();
        } else {
            throw new \Exception(self::XML_INVALID);
        }

        $this->offset = 0;
    }

    public function createPreferences() : array
    {
        $preferences = [];
        foreach ($this->preferences as $preference){
            $preferences [$preference->getName()]['direction'] = (string) $preference->direction;
            $preferences [$preference->getName()]['weight'] = (string) $preference->weight;
        }

        return $preferences;
    }

    public function hasMoreObjects() : bool
    {
        return (count($this->objects) > $this->offset);
    }

    public function hasObjects() : bool
    {
        return (isset($this->data->objects) && (count($this->data->objects) > 0));
    }

    private function hasPreferences() : bool
    {
        return (isset($this->data->preferences) && ($this->data->preferences->count() > 0));
    }
}