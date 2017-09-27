<?php

namespace UPSS\App\Preprocessors;

class PreferenceValidator extends Validator
{
    protected const INVALID_DATA = 'Preferences are invalid';


    protected const AVAILABLE_DIRECTIONS = [0,1];
    protected const WEIGHT_MIN = 0;
    protected const WEIGHT_MAX = 1;

    public function validate() : array
    {
        foreach ($this->inputData as $preference){
            if (isset($preference['direction']) && isset($preference['weight'])) {
                if (in_array($preference['direction'], self::AVAILABLE_DIRECTIONS)
                    && ($preference['weight'] >= self::WEIGHT_MIN && $preference['weight'] <= self::WEIGHT_MAX)){
                    continue;
                }
            }
            $this->fails();
        }

        return $this->success();
    }
}