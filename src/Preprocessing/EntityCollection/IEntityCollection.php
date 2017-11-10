<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

interface IEntityCollection extends IPreferenceCollection
{
    public function getEntities(): array;

    public function clearEntities();

    public function removeEntityFromCollection($index);

    public function addEntity(IEntity $entity);
}