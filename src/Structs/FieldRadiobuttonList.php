<?php

namespace GoBrave\PostTypeImporter\Structs;

use GoBrave\PostTypeImporter\Structs\Field;

class FieldRadiobuttonList extends Field
{
  protected $default_options = [
    'values'        => null,
    'default_value' => null
  ];

  protected function mergeOptions($options) {
    if(!isset($options['values']) OR !is_array($options['values'])) {
      throw new \InvalidArgumentException('Field of type radiobutton_list must have an option key named \'values\' with array values');
    }
    return parent::mergeOptions($options);
  }

  protected function optionsToMagicFields() {
    $options = parent::optionsToMagicFields();
    $options['options'] = implode(PHP_EOL, $options['values']);
    unset($options['values']);
    return $options;
  }
}
