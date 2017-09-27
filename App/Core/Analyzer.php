<?php

namespace UPSS\App\Core;

class Analyzer
{
    protected $objects;
    protected $preferences;

    protected $objectProps;
    protected $filteredObjects;

    public function __construct($data)
    {
        $this->objects = $data['objects'];
        $this->objectProps = array_keys($this->objects[0]);
        $this->preferences = $data['preferences'];
    }

    public function analyze()
    {

    }

    protected function filterObjects()
    {

    }

}