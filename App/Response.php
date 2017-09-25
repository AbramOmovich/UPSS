<?php

namespace UPSS\App;

class Response
{
    private $message;

    private const responseCodes =
        [
            200 => 'OK',
            400 => 'Bad Request',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        ];

    private $statusCode = 200;
    private $responseText = 'OK response';

    public function __construct($message = null)
    {
        $this->message = $message;
    }

    private function prepareHeader()
    {
        if (isset($_SERVER['SERVER_PROTOCOL'])){
            if (isset(self::responseCodes[$this->statusCode])){
                header($_SERVER['SERVER_PROTOCOL'] . " {$this->statusCode} ". self::responseCodes[$this->statusCode],true, $this->statusCode);
                return true;
            }
        }
        return false;
    }

    private function prepareMessage() {
        if ($this->message instanceof \Exception) {
            $this->responseText =
                $this->message->getMessage() . "\n" .
                $this->message->getFile() . " : " . $this->message->getLine();

            $this->statusCode = 400;

        } elseif (is_string($this->message)) {
            $this->responseText = $this->message;
            $this->statusCode = 200;

        } elseif (is_array($this->message)){
            $this->responseText = json_encode($this->message);
            $this->statusCode = 200;
        }
    }

    public function send()
    {
        $this->prepareMessage();
        $this->prepareHeader();

        return $this->responseText;
    }

}