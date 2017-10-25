<?php

namespace UPSS\Preprocessing\Validator;

use UPSS\Preprocessing\Entities\IEntity;

class EntityPropertiesValidator implements IEntityValidator
{
    public function validate(IEntity $entity): bool
    {
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
}
