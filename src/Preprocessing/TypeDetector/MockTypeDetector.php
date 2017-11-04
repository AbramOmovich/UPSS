<?php

namespace UPSS\Preprocessing\TypeDetector;

class MockTypeDetector implements ITypeDetector
{
    public function detectType($data) : string
    {
        return "HTTP";
    }
}