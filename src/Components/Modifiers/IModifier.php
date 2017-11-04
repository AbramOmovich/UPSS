<?php

namespace UPSS\Components\Modifiers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

interface IModifier
{

    /**
     * @param \UPSS\Preprocessing\EntityCollection\IEntityCollection $data
     * @param array $analytics
     *
     * Modifies entity collection or analysis results
     *
     * @return mixed
     */
    public function modify(IEntityCollection $data, array &$analytics = []);
}