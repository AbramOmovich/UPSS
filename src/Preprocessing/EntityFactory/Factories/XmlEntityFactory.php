<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;

use UPSS\Preprocessing\Entities\IEntity;
use UPSS\Preprocessing\Entities\XmlEntity;
use UPSS\Preprocessing\EntityFactory\EntityCreationException;
use UPSS\Preprocessing\EntityFactory\Factories\Helpers\PreferenceCreator;

class XmlEntityFactory implements IEntityFactory
{

    use PreferenceCreator;

    private const XML_INVALID = "XML data supplied is invalid";

    private $data;

    private $saxObjects = [];

    private $offset;

    private $amount;

    public function createEntity(): IEntity
    {
        $entity = new XmlEntity();
        if ((isset($this->saxObjects[$this->offset])) && ($this->saxObjects[$this->offset] instanceof \SimpleXMLElement)) {
            $reflectionClass = new \ReflectionClass(XmlEntity::class);
            $reflectionProperty = $reflectionClass->getProperty('node');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($entity,
                $this->saxObjects[$this->offset]);

            $this->offset++;
            $this->entities []= $entity;

            return $entity;
        }
        throw new \Exception(self::XML_INVALID);
    }

    public function setInputData($data)
    {
        $this->data = simplexml_load_string($data);
        if ($this->hasObjects()) {
            foreach ($this->data->children() as $object) {
                $this->saxObjects [] = $object;
            }
        } else {
            throw new EntityCreationException(self::XML_INVALID);
        }

        $this->offset = 0;
    }

    public function hasMoreObjects(): bool
    {
        return (count($this->data) > $this->offset);
    }

    public function hasObjects(): bool
    {
        if (!isset($this->amount)){
            $this->amount = count($this->data);
        }
        return (isset($this->data) && ($this->amount > 0));
    }
}