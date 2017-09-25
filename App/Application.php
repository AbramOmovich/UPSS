<?php

namespace UPSS\App;

use UPSS\App\Preprocessors\CompatibilityValidator;
use UPSS\App\Preprocessors\ObjectValidator;
use UPSS\App\Preprocessors\PreferenceValidator;

class Application
{
    public function handleRequest(Request $request)
    {
        try {
            $this->sendToValidator($request);
        } catch (\Exception $e) {
            return new Response($e);
        }

        return new Response();
    }

    public function sendToValidator($request)
    {
        if (isset($request['objects'])) {
            $validator = new ObjectValidator($request['objects']);
            $validObjects = $validator->validate();
        }

        if (isset($request['preferences']) && !empty($request['preferences'])) {
            $validator = new PreferenceValidator($request['preferences']);
            $validPrefs = $validator->validate();
        }

        if (isset($validObjects) && isset($validPrefs)){
            $validator = new CompatibilityValidator($validObjects, $validPrefs);
            $validator->validate();
        }
    }
}