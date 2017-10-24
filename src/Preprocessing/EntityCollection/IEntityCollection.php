<?php

namespace UPSS\Preprocessing\EntityCollection;

interface IEntityCollection
{

	public function getObjects();

	public function getPreferences();

	public function addToCollection(IEntity $entity);

	public function setPreferences();

	public function removeFromCollection($index);
}