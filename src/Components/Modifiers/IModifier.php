<?php

namespace UPSS\Components\Modifiers;

use UPSS\Preprocessing\EntityCollection\ICollection;

interface IModifier
{

    /**
     * @param \UPSS\Preprocessing\EntityCollection\ICollection $data
     * @param array $analytics
     *
     * Modifies entity collection or analysis results
     *
     * @return mixed
     */
    public function modify(ICollection $data, array &$analytics = []);
}