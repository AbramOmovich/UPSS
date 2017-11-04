<?php

namespace UPSS\Preprocessing\EntityFactory;

use UPSS\Preprocessing\Entities\IEntity;
use UPSS\Preprocessing\EntityCollection\EntityCollection;
use UPSS\Preprocessing\EntityCollection\ICollection;
use UPSS\Preprocessing\EntityCollection\IEntityCollection;
use UPSS\Preprocessing\EntityCollection\IPreferenceCollection;
use UPSS\Preprocessing\EntityCollection\PreferenceCollection;
use UPSS\Preprocessing\EntityFactory\Factories\IEntityFactory;
use UPSS\Preprocessing\Validator\IEntityValidator;
use UPSS\Preprocessing\Validator\IPreferencesValidator;
use UPSS\Preprocessing\Validator\ValidationException;
use UPSS\Storage\IStorage;

class EntityFactory
{

    public const PREFERENCE_COLLECTION = 1;

    public const ENTITY_COLLECTION = 2;

    private const PREPROCESSED_COLLECTION_DIR = 'preprocessed_collection';

    private $format;

    private $concreteFactory;

    private $data;

    private $collection;

    private $validator;

    private $storage;

    public function createCollection(
        $data,
        string $format,
        string $collectionType = self::PREFERENCE_COLLECTION
    ): ICollection {
        $this->data = $data;
        $this->format = $format;

        $this->resolveConcreteFactory();
        $this->concreteFactory->setInputData($this->data);

        if ($collectionType == self::PREFERENCE_COLLECTION) {
            $this->collection = $this->createPreferenceCollection();

        } elseif ($collectionType == self::ENTITY_COLLECTION) {
            $this->collection = $this->createEntityCollection();
        } else {
            throw new EntityCreationException("Invalid collection type");
        }

        return $this->collection;

    }


    public function setStorage(IStorage $storage)
    {
        $this->storage = $storage;
    }

    public function setValidator(IEntityValidator $validator)
    {
        $this->validator = $validator;
    }

    private function createPreferenceCollection(): ICollection
    {
        $preferenceCollection = null;
        //creating entities from data provided
        $entities = $this->createEntities();

        //generating unique identifier for collection based on entities array
        $serializedEntities = serialize($entities);
        $entityCollectionId = sha1($serializedEntities);

        //check if preferences already generated
        $result = $this->storage->select('preferences')
            ->where(self::PREPROCESSED_COLLECTION_DIR, $entityCollectionId)
            ->get();
        if ($result !== false){
            $result = unserialize($result);
        }

        //if no generated preferences - creating preference collection
        if (($result === false) || !($result instanceof IPreferenceCollection)){
            $preferenceCollection = new PreferenceCollection();
            $preferences = $this->createPreferences();
            $preferenceCollection->setPreferences($preferences);

            //add unique entity collection identifier
            $preferenceCollection->setEntitiesId($entityCollectionId);

            $this->storage->insert('preferences', serialize($preferenceCollection))
                ->where(self::PREPROCESSED_COLLECTION_DIR, $entityCollectionId)
                ->execute();
        } elseif ($result instanceof IPreferenceCollection){
            $preferenceCollection = $result;
        }


        //check if entity collection already exists in storage
        $result = $this->storage->select('entities')
            ->where(self::PREPROCESSED_COLLECTION_DIR, $entityCollectionId)
            ->get();
        if ($result !== false){
            $result = unserialize($result);
        }

        //if no saved entity collection or collection saved wrong
        //we have to generate new entity collection
        if (($result === false) || !($result instanceof IEntityCollection)){
            $entityCollection = new EntityCollection();
            foreach ($entities as $entity) {
                $entityCollection->addEntity($entity);
            }

            $this->storage->insert('entities', serialize($entityCollection))
                ->where(self::PREPROCESSED_COLLECTION_DIR, $entityCollectionId)
                ->execute();
        }

        if (!is_null($preferenceCollection)){
            return $preferenceCollection;
        } else {
            throw new EntityCreationException("Unable to create preference collection");
        }

    }

    private function createEntityCollection(): ICollection
    {
        $preferences = json_decode($this->data, true);

        //validate preferences
        if ($this->validator instanceof IPreferencesValidator) {
            if (!$this->validator->validatePreferences($preferences)) {
                throw new ValidationException("Invalid preferences");
            }
        } else {
            throw new ValidationException("Invalid validator");
        }

        //loading entity collection relative to this preferences
        $result = $this->storage->select('entities')
            ->where(self::PREPROCESSED_COLLECTION_DIR, $preferences['entities_id'])
            ->get();
        if ($result) {
            $result = unserialize($result);
            if (!$result) {
                throw new EntityCreationException("Data for preferences is broken");
            }

            if ($result instanceof IEntityCollection) {

                //filling entity collection with this preferences
                $entityCollection = $result;
                $entityCollection->setPreferences($preferences);

                return $entityCollection;
            }
        }

        throw new EntityCreationException("Invalid preferences. Data for them not exists");
    }

    private function resolveConcreteFactory()
    {
        $factoryClassName = __NAMESPACE__.'\\Factories\\'.ucfirst(strtolower($this->format)).'EntityFactory';
        $factory = new $factoryClassName;
        if ($factory instanceof IEntityFactory) {
            $this->concreteFactory = $factory;
        } else {
            throw new \Exception("Invalid factory class");
        }
    }

    private function createPreferences()
    {
        return $this->concreteFactory->createPreferences();
    }

    private function createEntities(): array
    {
        $entities = [];
        $concreteFactory = $this->concreteFactory;
        $index = 0;
        while ($concreteFactory->hasMoreObjects()) {
            $entity = $concreteFactory->createEntity();
            if ($this->validateEntity($entity, $index)) {
                $entities [] = $entity;
            }
        }

        return $entities;
    }

    private function validateEntity(IEntity $entity, int $index)
    {
        if ($this->validator->validateEntity($entity)) {
            return true;
        }
        throw new ValidationException("Entity [{$index}] is invalid");
    }

}