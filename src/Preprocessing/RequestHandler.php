<?php

namespace UPSS\Preprocessing;

use UPSS\Application;
use UPSS\Preprocessing\EntityCollection\ICollection;
use UPSS\Preprocessing\EntityFactory\EntityFactory;
use UPSS\Preprocessing\TypeDetector\ITypeDetector;

class RequestHandler implements IRequestHandler
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
        $validatorName = Application::getInstance()->getConfig('validator');
        $handler->factory->setValidator(new $validatorName);
        $handler->factory->setStorage(Application::getStorage());

        //if system got preferences.
        if (isset($request['preferences']) && !empty($request['preferences'])){
            return $handler->factory->createCollection($request['preferences'], 'json', EntityFactory::ENTITY_COLLECTION);

        //or it's got data
        } elseif (isset($request['data']) && !empty($request['data'])) {
            $handler->data = unserialize($request['data']);
            if (empty($handler->data)){
                throw new \Exception(self::NO_DATA);
            }

            if (isset($request['format'])) {
                $handler->format = $request['format'];
            } else {
                $handler->detectFormat();
            }

            return $handler->factory->createCollection($handler->data, $handler->format);

        } else {
            throw new \Exception(self::NO_DATA);
        }
    }

    protected function detectFormat()
    {
        $this->format = self::$typeDetector->detectType($this->data);
    }

}