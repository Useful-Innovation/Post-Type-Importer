<?php

namespace GoBrave\PostTypeImporter\Structs;

use GoBrave\PostTypeImporter\Structs\Field;

class FieldCheckboxList extends Field
{
  protected $default_options = [
    'options'       => null,
    'default_value' => null
  ];

  protected function mergeOptions($options) {
    if(!isset($options['values']) OR !is_array($options['values'])) {
      throw new \InvalidArgumentException('Field of type checkbox_list must have an option key named \'values\' with array values');
    }
    return parent::mergeOptions($options);
  }
}
