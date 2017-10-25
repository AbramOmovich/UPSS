<?php

namespace UPSS\Preprocessing\Validator;

use UPSS\Preprocessing\Entities\IEntity;

interface IEntityValidator
{
    public function validate(IEntity $data) : bool;
}