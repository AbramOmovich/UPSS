<?php

namespace UPSS\Preprocessing\EntityFactory\Factories;

use UPSS\Preprocessing\Entities\IEntity;

interface IEntityFactory
{
	public function createEntity() : IEntity;

	public function setInputData($data);

	public function createPreferences() : array ;

	public function hasMoreObjects() : bool ;

	public function hasObjects() : bool;
}