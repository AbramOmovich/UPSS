<?php

namespace UPSS\Preprocessing\TypeDetector;

class MockTypeDetector implements ITypeDetector
{
    public function detectType(mixed $data) : string
    {
        return "HTTP";
    }
}
?>