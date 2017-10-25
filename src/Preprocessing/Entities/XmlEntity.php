<?php

namespace UPSS\Preprocessing\Entities;

class XmlEntity implements IEntity
{
    private $node;
    private $properties;

    public function offsetExists($offset)
    {
        return (isset($this->properties[$offset]));
    }

    public function offsetGet($offset)
    {
        return $this->properties[$offset];
    }

    public function offsetSet($offset, $value) {}

    public function offsetUnset($offset) {}

    public function getProperties() : array
    {
        if (!isset($this->properties)){
            $this->initProperties();
        }

        return $this->properties;
    }

    private function initProperties()
    {
        $properties = [];
        foreach ($this->node->children() as $child){
            $count = $child->count();
            if ($count == 0){
                $properties [$child->getName()] = (string) $child;
            } else {
                $properties [$child->getName()] = $this->getNestedProperties($child);
            }
        }

        $this->properties = $properties;
    }

    private function getNestedProperties(\SimpleXMLElement $element) : array
    {
        $properties = [];
        foreach ($element->children() as $child)
        {
            if ($child->count() > 0){
                $properties[$child->getName()] = $this->getNestedProperties($child);
            } else {
              $properties[$child->getName()] = (string) $child;
            }
        }

        return $properties;
    }
}