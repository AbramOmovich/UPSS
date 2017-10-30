<?php

namespace UPSS\Postprocessing;

use UPSS\Postprocessing\ExceptionProcessors\IExceptionProcessor;
use UPSS\Preprocessing\EntityCollection\IEntityCollection;

class ResponseHandler implements IExceptionProcessor
{
    private const HTTP_HEADERS = [
        200 => 'OK',
        500 => 'Internal Server Error',
    ];
    private $data;

    public function __invoke(\Throwable $throwable)
    {
        $file = 'exception_log.txt';
        file_put_contents($file, "//////////////////////////\n", FILE_APPEND);
        file_put_contents($file, $throwable . "\n", FILE_APPEND);
        $this->header(500);
        echo $throwable;
    }

    public function send() : string
    {
        $this->header(200);
        return $this->data->getRaw();
    }

    public function setData(IEntityCollection $data)
    {
        $this->data = $data;
    }

    private function header(int $code)
    {
        header('HTTP/1.1' . " {$code} ". self::HTTP_HEADERS[$code],true, $code);
    }
}