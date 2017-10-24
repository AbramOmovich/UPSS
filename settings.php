<?php

use UPSS\Preprocessing\TypeDetector\MockTypeDetector;
use UPSS\Preprocessing\Validator\EntityObjectsValidator;

return [
  'validator' => EntityObjectsValidator::class,
  'type_detector' => MockTypeDetector::class
];