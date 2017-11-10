<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Application;
use UPSS\Preprocessing\Entities\IEntity;

class EntityCollection implements IEntityCollection
{
    private $page = 0;
    private $entities = [];
    private $preferences = [];

    public function getEntities(): array
    {
        return $this->entities;
    }

    public function getPreferences(): array
    {
        return $this->preferences['preferences'];
    }

    public function addEntity(IEntity $entity)
    {
        $this->entities [] = $entity;
    }

    public function setPreferences(array $preferences)
    {
        $this->preferences = $preferences;
    }

    public function removeEntityFromCollection($index = '')
    {
        if (isset($this->entities[$index])) {
            unset($this->entities[$index]);
        } else {
            throw new \Exception("Offset {$index} not exists in collection");
        }
    }


    public function getAsArray(): array
    {
        $output = [];
        $output['objects'] = [];
        $output['total'] = count($this->entities);
        $output['per_page'] = Application::getInstance()->getConfig('per_page');

        if (!isset($this->preferences['page'])){
            $this->preferences['page'] = $this->page;
        }

        if ($this->preferences['page'] >= 0){
            $this->preferences['page'] = (int) $this->preferences['page'];

            $start = $output['per_page'] * $this->preferences['page'];
            $end = $output['per_page'] * ($this->preferences['page'] + 1);

            for ($i = $start; ($i < $end) && ($i < $output['total']); $i++ ){
                $output['objects'][] = $this->entities[$i]->getProperties();
            }
        }

        $output['preferences'] = $this->preferences;
        return $output;
    }

    public function clearEntities()
    {
        $this->entities = [];
    }

    public function hasEntities(): bool
    {
        return (isset($this->entities) && !empty($this->entities));
    }

    public function hasPreferences(): bool
    {
        return (isset($this->preferences) && !empty($this->preferences));
    }

    public function setEntitiesId(string $id)
    {
        return $this->preferences['entities_id'] = $id;
    }

    public function getEntitiesId(): string
    {
        return $this->preferences['entities_id'];
    }
}
