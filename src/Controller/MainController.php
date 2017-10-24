<?php

namespace UPSS\Controller;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;
use UPSS\Storage\IStorage;

class MainController
{
	  private $components;
	  private $storage;
	  private $alalysisResult;
	  private $input;
	  private $output;
	  private $dataHashSum;

	  public function __construct(IEntityCollection $data, array $components, IStorage $storage)
	  {
	  }

	  public function handle()
	  {
	  }

	  private function checkCachedResult()
	  {
	  }


	  private function lookInStorage(string $type)
	  {
	  }


	  private function getFromStrorage(string $type)
	  {
	  }


	  private function saveInStorage(string $type, mixed $data)
	  {
	  }

	  private function sendToAnalyzers()
	  {
	  }

	  private function sendToModifiers()
	  {
	  }

}