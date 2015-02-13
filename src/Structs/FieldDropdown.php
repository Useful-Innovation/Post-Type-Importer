<?php

namespace GoBrave\PostTypeImporter\Structs;

use GoBrave\PostTypeImporter\Structs\Field;

class FieldDropdown extends Field
{
  protected $default_options = [
    'values'        => null,
    'default_value' => null,
    'multiple'      => false
  ];

  protected function mergeOptions($options) {
    if(!isset($options['values']) OR !is_array($options['values'])) {
      throw new \InvalidArgumentException('Field of type dropdown must have an option key named \'values\' with array values');
    }
    return parent::mergeOptions($options);
  }
}
