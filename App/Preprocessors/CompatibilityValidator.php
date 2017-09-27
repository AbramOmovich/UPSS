<?php

namespace UPSS\App\Preprocessors;

class CompatibilityValidator extends Validator
{
    protected const INVALID_DATA = 'Data is incompatible';

    protected $preferences;

    public function __construct(array $objects, array $preferences)
    {
        parent::__construct($objects);
        $this->preferences = $preferences;
    }

    public function validate() : array
    {
        $objectParams = array_keys($this->inputData[0]);
        $prefParams = array_keys($this->preferences);

        if (!empty(array_diff($prefParams, $objectParams))) $this->fails();

        return $this->success();
    }
}