<?php

namespace UPSS\Postprocessing;

use UPSS\Postprocessing\ExceptionProcessors\IExceptionProcessor;

class ExceptionHandler
{
	  private $processor;

	  public function __construct(IExceptionProcessor $processor)
      {
          $this->processor = $processor;
          set_exception_handler([$this, 'handle']);
      }

	  public function handle(\Throwable $throwable)
      {
          $this->processor->__invoke($throwable);
      }

}