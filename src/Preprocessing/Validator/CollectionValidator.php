<?php

namespace UPSS\Preprocessing\Validator;

use UPSS\Preprocessing\Entities\IEntity;

class CollectionValidator implements IEntityValidator, IPreferencesValidator
{
    public function validateEntity(IEntity $entity): bool
    {
        //TODO: remake validation
        $properties = $entity->getProperties();
        if (empty($properties)){
            return false;
        } else {
            foreach ($properties as $property){
                if (!$this->isValidProperty($property)){
                    return false;
                }
            }
        }

        return true;
    }

    private function isValidProperty($property) : bool
    {
        if (is_array($property) && !empty($property)){
            foreach ($property as $subProperty){
                if (!$this->isValidProperty($subProperty)){
                    return false;
                }
            }
        }
        elseif (!is_scalar($property)){
            return false;
        }

        return true;
    }

    public function validatePreferences(array $preferences): bool
    {
        if (empty($preferences)){
            return false;
        }

        if (!isset($preferences['entities_id'])){
            return false;
        }

        if (!isset($preferences['preferences']) || empty($preferences['preferences'])){
            return false;
        }

        foreach ($preferences['preferences'] as $preference => $settings){
            if (!isset($settings['weight']) &&
                (!isset($settings['direction']) || !isset($settings['match']))
            ){
                return false;
            }
        }

        return true;
    }
}
