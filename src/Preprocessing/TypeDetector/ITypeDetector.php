<?php

namespace UPSS\Preprocessing\TypeDetector;

interface ITypeDetector
{
    public function detectType(mixed $data) : string ;
}