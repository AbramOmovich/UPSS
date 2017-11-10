<?php

namespace UPSS;

use UPSS\Controller\IController;
use UPSS\Postprocessing\IExceptionHandler;
use UPSS\Postprocessing\IResponseHandler;
use UPSS\Preprocessing\IRequestHandler;
use UPSS\Storage\IStorage;
use UPSS\Storage\StorageException;

class Application
{
    private const CONFIG_MISSING = 'Config entry [{entry}] is missing';

    private static $instance;
    private static $storage;
    private $config;

    private $requestHandler;
    private $responseHandler;
    private $exceptionHandler;

    public static function getInstance()
    {
       return self::$instance;
    }

    public function __construct(array $settings)
    {
        $this->config = $settings;
        self::$instance = $this;
    }

    public function getConfig($name)
    {
        if (isset($this->config[$name])){
            return $this->config[$name];
        } else {
            throw new \Exception(str_replace('{entry}', $name, self::CONFIG_MISSING));
        }
    }

    public function setConfig($name, $value)
    {
        $this->config[$name] = $value;
    }

    public function process()
    {
        //creating collection
        $entityCollection = $this->requestHandler::createFromGlobals();

        //creating controller
        $controllerClass = $this->getConfig('controller');
        $components = $this->getConfig('components');
        $controller = new $controllerClass;
        if ($controller instanceof IController){
            $controller->initialize($entityCollection, $components, self::getStorage());

            //processing collection
            $entityCollection = $controller->handle();

            //processing response
            $this->responseHandler->setData($entityCollection);
            echo $this->responseHandler->send();
        } else {
            throw new \Exception("Controller [{$controllerClass}] does not implements IController interface");
        }
    }

    public function initialize(IRequestHandler $requestHandler,  IResponseHandler $responseHandler, IExceptionHandler $exceptionHandler)
    {
        $this->requestHandler = $requestHandler;
        $this->responseHandler = $responseHandler;
        $this->exceptionHandler = $exceptionHandler;

        $type_detector = $this->getConfig('type_detector');
        $requestHandler::setTypeDetector(new $type_detector);

        $exceptionProcessorClass = $this->getConfig('exception_processor');

        $exceptionHandler->setProcessor($exceptionProcessorClass::getProcessor());
    }

    public static function getStorage() : IStorage
    {
        if (isset(self::$storage)){
            return self::$storage;
        } else {
            $storageSettings = self::$instance->getConfig('storage');
            $storageClass = $storageSettings['class'];
            $storage = new $storageClass($storageSettings);
            if ($storage instanceof IStorage){
                self::$storage = $storage;
                return $storage;
            }
            else{
                throw new StorageException("Class {$storageClass} doesn't implements IStorage interface");
            }
        }
    }

}