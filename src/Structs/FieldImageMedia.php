<?php

namespace GoBrave\PostTypeImporter\Structs;

class FieldImageMedia extends Field
{
  protected $default_options = [
    'css_class'  => 'magic_fields',
    'max_height' => '',
    'max_width'  => '',
    'custom'     => '',
    'image_size' => null
  ];

  public function toArray() {
    $array = parent::toArray();
    $array['options']['image_size'] = $array['options']['image_size']->getName();
    return $array;
  }
}
