<?php

namespace UPSS\Preprocessing\EntityCollection;


interface ICollection
{
    public function getAsArray(): array;

    public function hasEntities(): bool;

    public function hasPreferences(): bool;
}