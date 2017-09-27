<?php

namespace UPSS\App\Preprocessors;

class PreferenceValidator extends Validator
{
    protected const INVALID_DATA = 'Preferences are invalid';

    public function validate() : array
    {
        foreach ($this->inputData as $preference){
            if (isset($preference['direction']) && isset($preference['weight'])) {
                if (in_array($preference['direction'], [0,1]) && ($preference['weight'] >= 0 && $preference['weight'] <= 1)){
                    continue;
                }
            }
            $this->fails();
        }

        return $this->success();
    }
}