<?php

namespace UPSS\Postprocessing;

class ExceptionHandler
{
	  private $processor;

	  public function __construct(IExceptionProcessor $processor) {}

	  private function handle(\Throwable $throwable) {}

}