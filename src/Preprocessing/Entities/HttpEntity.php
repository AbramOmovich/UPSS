<?php

namespace UPSS\Preprocessing\Entities;

class HttpEntity implements IEntity
{
    private $properties;

    public function getProperties() : array {
        return $this->properties;
    }

	  public function getPropertyByName(string $name)
    {
        if (isset($this->properties[$name])){
            return $this->properties[$name];
        }
        else return false;
    }

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
}