<?php

namespace UPSS\Preprocessing;

use UPSS\Config;
use UPSS\Preprocessing\EntityCollection\IEntityCollection;
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

    public static function createFromGlobals() : IEntityCollection
    {
	      self::$instance = new self();
	      $handler = self::$instance;
	      $request = &$GLOBALS['_' . $_SERVER['REQUEST_METHOD']];
	      if (isset($request['data'])){
	          $handler->data = $request['data'];

	          if (isset($request['format'])){
	              $handler->format = $request['format'];
            } else {
                $handler->detectFormat();
            }

            $handler->factory = new EntityFactory();
	          $validatorName = Config::getInstance()->get('validator');
	          $handler->factory->setValidator(new $validatorName);

	          return $handler->factory->createEntityCollection($handler->data, $handler->format);

        } else {
	          throw new \Exception(self::NO_DATA);
        }
	  }

	  protected function detectFormat()
	  {
	      $this->format = self::$typeDetector->detectType($this->data);
	  }

}