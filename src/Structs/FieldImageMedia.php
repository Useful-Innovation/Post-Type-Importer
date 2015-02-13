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

  protected function mergeOptions($options) {
    if(!isset($options['image_size']) OR !($options['image_size'] instanceof ImageSize)) {
      throw new \InvalidArgumentException('Field of type image_media must have an option key named \'image_size\' with a string value and as valid image size');
    }
    return parent::mergeOptions($options);
  }

  public function toMagicFields() {
    $array = parent::toMagicFields();
    $array['options']['image_size'] = $array['options']['image_size']->getName();
    return $array;
  }
}
