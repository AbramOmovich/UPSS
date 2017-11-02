<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

interface ICollection
{
    public function getEntities(): array;

    public function getPreferences(): array;

    public function addToCollection(IEntity $entity);

    public function setPreferences(array $preferences);

    public function removeFromCollection($index);

    public function clearEntities();

    public function getAsArray(): array;

    public function hasEntities(): bool;

    public function hasPreferences(): bool;
}