<?php

namespace UPSS\Preprocessing;

use UPSS\Config;
use UPSS\Preprocessing\EntityCollection\ICollection;
use UPSS\Preprocessing\EntityFactory\EntityFactory;
use UPSS\Preprocessing\TypeDetector\ITypeDetector;

class RequestHandler
{
    private const NO_DATA = "No data provided";

    private $format;
    private $data;
    private $factory;
    private static $typeDetector;
    private static $instance;

    public static function setTypeDetector(ITypeDetector $detector)
    {
        self::$typeDetector = $detector;
    }

    public static function createFromGlobals(): ICollection
    {
        self::$instance = new self();
        $handler = self::$instance;
        $request = &$GLOBALS['_' . $_SERVER['REQUEST_METHOD']];

        $handler->factory = new EntityFactory();
        $validatorName = Config::getInstance()->get('validator');
        $handler->factory->setValidator(new $validatorName);

        //if system got preferences.
        //For now it's always json.
        if (isset($request['preferences']) && !empty($request['preferences'])){
            return $handler->factory->createCollection($request['preferences'], 'json');

        //or it's got data
        } elseif (isset($request['data']) && !empty($request['data'])) {
            if (isset($request['format'])) {
                $handler->format = $request['format'];
            } else {
                $handler->detectFormat();
            }

            return $handler->factory->createCollection($request['data'], $handler->format);

        } else {
            throw new \Exception(self::NO_DATA);
        }
    }

    protected function detectFormat()
    {
        $this->format = self::$typeDetector->detectType($this->data);
    }

}