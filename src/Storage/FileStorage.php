<?php

namespace UPSS\Storage;

class FileStorage implements IStorage
{
    public function __construct(array $settings) {}


    public function select(string $bin)
    {
        // TODO: Implement select() method.
    }

    public function condition(
      string $field,
      string $value,
      string $operator,
      string $condition
    ) {
        // TODO: Implement condition() method.
    }

    public function insert(array $data)
    {
        // TODO: Implement insert() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function merge(array $data)
    {
        // TODO: Implement merge() method.
    }

    public function execute()
    {
        // TODO: Implement execute() method.
    }

    public function get()
    {
        // TODO: Implement get() method.
    }
}