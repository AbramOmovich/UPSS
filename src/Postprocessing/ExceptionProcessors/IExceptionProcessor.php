<?php

namespace UPSS\Postprocessing\ExceptionProcessors;

interface IExceptionProcessor
{
    public function __invoke(\Throwable $throwable);

    public static function getProcessor() : IExceptionProcessor;
}