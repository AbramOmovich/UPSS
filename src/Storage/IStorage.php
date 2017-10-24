<?php

namespace UPSS\Storage;

interface IStorage
{
	  public function __construct(array $settings);

	  public function select(string $bin);

	  public function condition(string $field, string $value, string $operator, string $condition);

	  public function insert(array $data);

	  public function update(array $data);

	  public function merge(array $data);

	  public function execute();

	  public function get();
}
