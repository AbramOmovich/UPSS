<?php

namespace UPSS\Preprocessing\Entities;

interface IEntity extends \ArrayAccess
{
    public function getProperties() : array;
}