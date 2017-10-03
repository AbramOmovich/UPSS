<?php

namespace UPSS\App;

use UPSS\App\Core\Analyzer;
use UPSS\App\Preprocessors\CompatibilityValidator;
use UPSS\App\Preprocessors\ObjectValidator;
use UPSS\App\Preprocessors\PreferenceValidator;

class Application
{
    private const STATE_NOTHING = 0;
    private const STATE_OBJECTS = 1;
    private const STATE_PREFERENCES = 2;

    private $state;

    public function handleRequest(Request $request)
    {
        $this->detectState($request);

        try {
            $this->sendToValidator($request);
        } catch (\Exception $e) {
            return new Response($e);
        }

        $responseData = $this->prepareResponse($request);
        return new Response($responseData);
    }

    private function detectState(Request $request)
    {
        $this->state = self::STATE_NOTHING;
        if (isset($request['objects'])) $this->state = $this->state | self::STATE_OBJECTS;
        if (isset($request['preferences'])) $this->state = $this->state | self::STATE_PREFERENCES;
    }

    private function sendToValidator(Request $request)
    {
        //TODO: IMPLEMENT CHAIN RESPONSIBILITY
        switch ($this->state){
            case self::STATE_OBJECTS :
                $validator = new ObjectValidator($request['objects']);
                $validObjects = $validator->validate();
                break;

            case self::STATE_PREFERENCES and self::STATE_OBJECTS :
                $validator = new ObjectValidator($request['objects']);
                $validObjects = $validator->validate();

                if(!empty($request['preferences'])) {
                    $validator = new PreferenceValidator($request['preferences']);
                    $validPrefs = $validator->validate();

                    $validator = new CompatibilityValidator($validObjects, $validPrefs);
                    $validator->validate();
                }
                break;
        }
    }

    private function prepareResponse(Request $request)
    {
        switch ($this->state) {
            case self::STATE_OBJECTS :
                return $this->initPreferences(array_keys($request['objects'][0]));

            case self::STATE_PREFERENCES and self::STATE_OBJECTS :
                return $this->sendToAnalyzer($request);
                break;
        }
        return null;
    }

    private function initPreferences($prefs)
    {
        foreach ($prefs as &$pref) {
            $pref = [
                $pref => [
                    'direction' => 1, // 1 stands for max, 0 for min
                    'weight' => 0.5   // Less important param has less weight
                ]
            ];
        }

        return $prefs;
    }

    private function sendToAnalyzer($data)
    {
        $analyzer = new Analyzer($data);
        return $analyzer->analyze();
    }
}