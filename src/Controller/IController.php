<?php

namespace UPSS\Controller;

use UPSS\Preprocessing\EntityCollection\ICollection;
use UPSS\Storage\IStorage;

interface IController
{
    public function initialize(ICollection $collection, array $components, IStorage $storage = null);

    public function handle() : ICollection;
}