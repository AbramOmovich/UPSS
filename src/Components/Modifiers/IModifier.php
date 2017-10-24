<?php

namespace UPSS\Components\Modifiers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

interface IModifier
{
    public function modify(IEntityCollection $data, array $analytics = []);
}