<?php

use UPSS\Preprocessing\TypeDetector\MockTypeDetector;
use UPSS\Preprocessing\Validator\EntityPropertiesValidator;

return [
  'validator' => EntityPropertiesValidator::class,
  'type_detector' => MockTypeDetector::class
];