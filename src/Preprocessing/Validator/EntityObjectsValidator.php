<?php

namespace UPSS\Preprocessing\Validator;

use UPSS\Preprocessing\Entities\IEntity;

class EntityObjectsValidator extends AbstractValidator
{
    public function validate(IEntity $data): bool
    {
        return true;
    }
}
