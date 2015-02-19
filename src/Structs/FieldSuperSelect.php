<?php

namespace GoBrave\PostTypeImporter\Structs;

class FieldSuperSelect extends Field
{
  protected $default_options = ['post_types' => 'all'];

  public function toMagicFields() {
    $array = parent::toMagicFields();
    $array['type'] = 'textbox';
    return $array;
  }

  protected function optionsToMagicFields() {
    $options = parent::optionsToMagicFields();
    $options['force_type'] = 'related_type';
    return $options;
  }
}
