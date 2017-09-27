<?php

namespace UPSS\App\Preprocessors;

class ObjectValidator extends Validator
{
    protected const INVALID_DATA = 'Objects are invalid';

    public function validate()
    {
        if (count($this->inputData) < 2) $this->fails(); //There is no need to range 1 or zero objects

        $paramKeys = array_keys($this->inputData[0]);
        foreach ($this->inputData as $object){
            if ($paramKeys !== array_keys($object)) {
                $this->fails();
            }
        }

        return $this->success();
    }
}