<?php

namespace UPSS\Postprocessing;

use UPSS\Postprocessing\ExceptionProcessors\IExceptionProcessor;
use UPSS\Preprocessing\EntityCollection\ICollection;

class ResponseHandler implements IResponseHandler ,IExceptionProcessor
{
    private const HTTP_HEADERS = [
        200 => 'OK',
        500 => 'Internal Server Error',
    ];
    private $data;

    private static $instance;

    public function __construct()
    {
        self::$instance = $this;
    }

    public function __invoke(\Throwable $throwable)
    {
        $file = 'exception_log.txt';
        file_put_contents($file, "//////////////////////////\n", FILE_APPEND);
        file_put_contents($file, $throwable . "\n", FILE_APPEND);
        $this->header(500);
        echo $throwable->getMessage();
    }

    public function send() : string
    {
        $this->header(200);
        $response = json_encode($this->data->getAsArray());
        if ($this->data->hasPreferences() && !$this->data->hasEntities()){
            file_put_contents('mock_data/mock_preferences.json', $response);
        }

        return $response;
    }

    public function setData(ICollection $data)
    {
        $this->data = $data;
    }

    private function header(int $code)
    {
        if (isset($_SERVER['SERVER_PROTOCOL'])){
            header($_SERVER['SERVER_PROTOCOL'] . " {$code} ".
                self::HTTP_HEADERS[$code],true, $code);
        }
    }

    public static function getProcessor(): IExceptionProcessor
    {
        if (isset(self::$instance)){
            return self::$instance;
        } else {
            throw new \Exception("Processor is not created");
        }
    }
}