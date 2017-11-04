<?php

namespace UPSS\Preprocessing\EntityCollection;

interface IPreferenceCollection extends ICollection
{
    public function getPreferences(): array;

    public function setPreferences(array $preferences);

    public function setEntitiesId(string $id);

    public function getEntitiesId(): string;
}