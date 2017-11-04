<?php

namespace UPSS\Preprocessing\Entities;

class JsonEntity implements IEntity
{
    private $properties;

    public function offsetExists($offset)
    {
        return isset($this->properties[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->properties[$offset];
    }

    public function offsetSet($offset, $value) {}

    public function getProperties(): array
    {
        return $this->properties;
    }

    public function offsetUnset($offset) {}
}
