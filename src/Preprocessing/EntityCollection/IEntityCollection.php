<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

interface IEntityCollection
{
	public function getEntities() : array;

	public function getPreferences();

	public function addToCollection(IEntity $entity);

	public function setPreferences(array $preferences);

	public function removeFromCollection($index);

	public function clearEntities();

	public function getAsArray() : array;
}