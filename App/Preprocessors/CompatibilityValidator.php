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

    public function validate()
    {
        $objectParams = array_keys($this->inputData[0]);
        $prefParams = array_keys($this->preferences);

        if ($objectParams == $prefParams) return $this->success();

        foreach ($prefParams as $preference){
            if (!in_array($preference, $objectParams)) {
                $this->fails();
            }
        }

        return $this->success();
    }
}