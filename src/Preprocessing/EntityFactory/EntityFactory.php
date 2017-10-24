<?php

namespace UPSS\Preprocessing\EntityFactory;

use UPSS\Preprocessing\EntityCollection\IEntityCollection;
use UPSS\Preprocessing\EntityFactory\Factories\IEntityFactory;
use UPSS\Preprocessing\Validator\AbstractValidator;

class EntityFactory
{

	  private $type;
	  private $concreteFactory;
	  private $data;
	  private $validator;

	  public function createEntityCollection(mixed $data, string $type) : IEntityCollection
	  {
	      $this->data = $data;
	      $this->type = $type;

	      $this->resolveConcreteFactory();
	      $entities = $this->createEntities();
	  }


	  public function setValidator(AbstractValidator $validator)
	  {
	      $this->validator = $validator;
	  }

	  private function resolveConcreteFactory()
	  {
	      $factoryClassName = 'Factories\\' . ucfirst($this->type) . 'EntityFactory';
	      $factory = new $factoryClassName;
	      if ($factory instanceof IEntityFactory){
            $this->concreteFactory = $factory;
        } else {
	          throw new \Exception("Invalid factory class");
        }
	  }

	  private function createPreferences()
	  {
	  }

	  private function createEntities() : array
	  {
	      $entities = [];
	      $this->concreteFactory->setInputData($this->data);
	      while ($this->concreteFactory->hasMoreObjects()){
	          $entity = $this->concreteFactory->createEntity();
	          if ($this->validator->validate($entity)){
	              $entities []= $entity;
	              //TODO: Handle invalid objects
            }
        }
	  }

	  private function validateEntity()
	  {
	  }

}