<?php

namespace UPSS\Preprocessing\Validator;

interface IPreferencesValidator
{
    public function validatePreferences(array $preferences): bool;
}