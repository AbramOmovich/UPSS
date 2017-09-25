<?php

namespace UPSS\App\Preprocessors;

abstract class Validator
{
    protected const INVALID_DATA = 'Data supplied is invalid';

    protected $inputData;

    public function __construct(array $data)
    {
        if (empty($data)) $this->fails();
        $this->inputData = $data;
    }

    abstract public function validate();

    protected function fails()
    {
        throw new \Exception(static::INVALID_DATA);
    }

    protected function success() : array
    {
        return $this->inputData;
    }
}