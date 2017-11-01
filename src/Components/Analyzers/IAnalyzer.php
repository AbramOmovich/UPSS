<?php

namespace UPSS\Components\Analyzers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

interface IAnalyzer
{

    /**
     * Analyzes entity collection.
     * Returns array with weights of entities;
     * [ weights_name => weights_array[] ]
     *
     * Index in weights array is relative to index of entity in the collection.
     * If some entities do not have relative index in weight array, it means
     * that they are not preferable.
     *
     * @param \UPSS\Preprocessing\EntityCollection\IEntityCollection $data
     * @return array
     */
    public function analyze(IEntityCollection $data): array;
}
