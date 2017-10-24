<?php

namespace UPSS;

class Config
{
    private const CONFIG_MISSING = 'Config entry [{entry}] is missing';

    private static $instance;
    private $conifg;

    public static function getInstance()
    {
       return self::$instance;
    }

    public function __construct(string $file)
    {
        $this->config = $file;
        self::$instance = $this;
    }

    public function get($name)
    {
        if (isset($this->config[$name])){
            return $this->config[$name];
        } else {
            throw new \Exception(str_replace('{entry}', $name, self::CONFIG_MISSING));
        }
    }

    public function set($name, $value)
    {
        $this->config[$name] = $value;
    }

}