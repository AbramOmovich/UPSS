<?php

namespace UPSS\App;

class Request implements \ArrayAccess
{
    private $parameters = [];

    public static function create($params = [])
    {
        $request = new self();
        if (!empty($params)){
            $request->parameters = $params;
        }elseif (isset($_SERVER['REQUEST_METHOD'])) {
            $request->parameters = $GLOBALS['_' . $_SERVER['REQUEST_METHOD']];
        }

        return $request;
    }

    public function getAll() {
        return $this->parameters;
    }


    public function offsetExists($offset)
    {
        return isset($this->parameters[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->parameters[$offset];
    }

    public function offsetSet($offset, $value){}

    public function offsetUnset($offset){}
}