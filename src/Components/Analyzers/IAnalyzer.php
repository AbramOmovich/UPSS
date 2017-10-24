<?php

namespace UPSS\Components\Analyzers;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;

interface IAnalyzer
{
    public function analyze(IEntityCollection $data) : array;
}
