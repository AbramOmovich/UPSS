<?php

namespace UPSS\App\Core;

class Analyzer
{
    private const EXT_MIN = 0;
    private const EXT_MAX = 1;

    private $objects;
    private $preferences;

    private $amountOfObjects;
    private $objectProps;
    private $propsExtrema;
    private $preparedObjects;

    public function __construct($data)
    {
        $this->objects = $data['objects'];
        $this->amountOfObjects = count($this->objects);
        $this->objectProps = array_keys($this->objects[0]);
        $this->preferences = $data['preferences'];
    }

    public function analyze()
    {
        $this->findExtrema();
        $this->prepareObjects();
        return $this->getOrderedObjects();
    }

    /**
     * Finds extrema values of properties
     * i.e. min or max depending on direction value in preferences
     */
    private function findExtrema()
    {
        foreach ($this->objectProps as $prop){
            $extrema = $this->objects[0][$prop];

            if (isset($this->preferences[$prop])){
                if ($this->preferences[$prop]['direction'] == self::EXT_MIN){
                    for($i = 1; $i < $this->amountOfObjects; $i++){
                        if ($this->objects[$i][$prop] < $extrema) $extrema = $this->objects[$i][$prop];
                    }
                } elseif ($this->preferences[$prop]['direction'] == self::EXT_MAX) {
                    for($i = 1; $i < $this->amountOfObjects; $i++){
                        if ($this->objects[$i][$prop] > $extrema) $extrema = $this->objects[$i][$prop];
                    }
                }

                $this->propsExtrema[$prop] = $extrema;
            }
        }
    }


    /**
     * Prepare order of object.
     * Produces array of keys of original objects
     */
    private function prepareObjects()
    {
        $this->preparedObjects = $this->objects;

        foreach ($this->preparedObjects as &$object){
            foreach ($this->propsExtrema as $propName => $extremum){

                //Making object properties non-dimensional
                if ($this->preferences[$propName]['direction'] == 1){
                    $object[$propName] = $object[$propName] / $extremum;
                } elseif ($this->preferences[$propName]['direction'] == 0){
                    $object[$propName] = $extremum / $object[$propName];
                }

                //applying property weight
                $object[$propName] = $this->preferences[$propName]['weight'] / $object[$propName];
            }

            //Making whole object's priority
            $object = array_sum($object);
        }

        asort($this->preparedObjects);
        $this->preparedObjects = array_keys($this->preparedObjects);
    }

    function getOrderedObjects()
    {
        $objects = [];
        foreach ($this->preparedObjects as $objectKey){
            $objects []= $this->objects[$objectKey];
        }

        return $objects;
    }
}