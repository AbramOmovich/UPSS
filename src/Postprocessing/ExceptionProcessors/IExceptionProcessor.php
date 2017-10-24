<?php

namespace UPSS\Postprocessing;

interface IExceptionProcessor
{
    public function __invoke(\Throwable $throwable);

    public function processException();
}