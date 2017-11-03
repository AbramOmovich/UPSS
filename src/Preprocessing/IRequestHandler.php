<?php

namespace UPSS\Preprocessing;

use UPSS\Preprocessing\EntityCollection\ICollection;
use UPSS\Preprocessing\TypeDetector\ITypeDetector;

interface IRequestHandler
{
    public static function setTypeDetector(ITypeDetector $detector);

    public static function createFromGlobals(): ICollection;
}