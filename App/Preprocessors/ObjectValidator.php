<?php

namespace UPSS\App\Preprocessors;

class ObjectValidator extends Validator
{
    protected const INVALID_DATA = 'Objects are invalid';

    public function validate() : array
    {
        $paramKeys = array_keys($this->inputData[0]);
        foreach ($this->inputData as $object){
            if ($paramKeys !== array_keys($object)) {
                $this->fails();
            }
        }

        return $this->success();
    }
}