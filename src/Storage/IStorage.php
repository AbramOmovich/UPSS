<?php

namespace UPSS\Storage;

interface IStorage
{
	  public function __construct(array $settings);

	  public function select(string $type) : IStorage;

	  public function where(string $field, string $value, string $operator = '=') : IStorage;

	  public function insert(string $type, $data) : IStorage;

	  public function execute();

	  public function get();
}
