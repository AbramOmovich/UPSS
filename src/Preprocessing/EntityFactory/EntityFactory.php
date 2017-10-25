<?php

namespace UPSS\Preprocessing\EntityFactory;

use UPSS\Preprocessing\Entities\IEntity;
use UPSS\Preprocessing\EntityCollection\EntityCollection;
use UPSS\Preprocessing\EntityCollection\IEntityCollection;
use UPSS\Preprocessing\EntityFactory\Factories\IEntityFactory;
use UPSS\Preprocessing\Validator\IEntityValidator;
use UPSS\Preprocessing\Validator\ValidationException;

class EntityFactory
{

	  private $type;
	  private $concreteFactory;
	  private $data;
	  private $validator;

	  public function createEntityCollection($data, string $type) : IEntityCollection
	  {
	      $this->data = $data;
	      $this->type = $type;

	      $this->resolveConcreteFactory();
        $this->concreteFactory->setInputData($this->data);
        $preferences = $this->createPreferences();
	      $entities = $this->createEntities();

	      $collection = new EntityCollection();
	      $collection->setPreferences($preferences);
	      foreach ($entities as $entity){
	          $collection->addToCollection($entity);
        }

        return $collection;
	  }


	  public function setValidator(IEntityValidator $validator)
	  {
	      $this->validator = $validator;
	  }

	  private function resolveConcreteFactory()
	  {
	      $factoryClassName = __NAMESPACE__ . '\\Factories\\' . ucfirst(strtolower($this->type)) . 'EntityFactory';
	      $factory = new $factoryClassName;
	      if ($factory instanceof IEntityFactory){
            $this->concreteFactory = $factory;
        } else {
	          throw new \Exception("Invalid factory class");
        }
	  }

	  private function createPreferences()
	  {
	      return $this->concreteFactory->createPreferences();
	  }

	  private function createEntities() : array
	  {
	      $entities = [];
	      $concreteFactory = $this->concreteFactory;
	      $index = 0;
	      while ($concreteFactory->hasMoreObjects()){
	          $entity = $concreteFactory->createEntity();
	          if ($this->validateEntity($entity, $index)){
	              $entities []= $entity;
            }
        }

        return $entities;
	  }

	  private function validateEntity(IEntity $entity, int $index)
	  {
	      if ($this->validator->validate($entity)){
	          return true;
        }
        throw new ValidationException("Entity [{$index}] is invalid");
	  }

}