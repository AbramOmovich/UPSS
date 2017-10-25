<?php

namespace UPSS\Preprocessing\EntityCollection;

use UPSS\Preprocessing\Entities\IEntity;

interface IEntityCollection
{
	public function getObjects() : array ;

	public function getPreferences();

	public function addToCollection(IEntity $entity);

	public function setPreferences(array $preferences);

	public function removeFromCollection($index);
}