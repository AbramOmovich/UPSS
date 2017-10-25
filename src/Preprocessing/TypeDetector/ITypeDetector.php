<?php

namespace UPSS\Preprocessing\TypeDetector;

interface ITypeDetector
{
    public function detectType($data) : string ;
}