<?php

namespace UPSS\Preprocessing\Validator;

use UPSS\Preprocessing\Entities\IEntity;

abstract class AbstractValidator
{
    protected const VALIDATION_ERROR = "Validation exception";
    protected $data;

    abstract public function validate(IEntity $data) : bool;

    protected function fails(string $message = null)
    {
        if (is_null($message)){
            throw new ValidationException(self::VALIDATION_ERROR);
        } else {
            throw new ValidationException($message);
        }
    }

}