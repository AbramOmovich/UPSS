<?php

namespace UPSS\Postprocessing;

use UPSS\Postprocessing\ExceptionProcessors\IExceptionProcessor;

interface IExceptionHandler
{
    public function setProcessor(IExceptionProcessor $processor);

    public function handle(\Throwable $throwable);
}