<?php

namespace UPSS\Preprocessing\TypeDetector;

class RoughTypeDetector implements ITypeDetector
{
    public function detectType($data) : string
    {
        $detectors = get_class_methods(self::class);
        foreach ($detectors as $detector){
            if ($detector === __FUNCTION__){
                continue;
            }

            if ($this->$detector($data)){
                return $detector;
            }
        }
        throw new \Exception("Unknown format of data");
    }

    private function http($data)
    {
        return is_array($data);
    }

    private function json($data)
    {
        return (json_decode($data) !== false);
    }

    private function xml($data)
    {
        return (simplexml_load_string($data) !== false);
    }
}