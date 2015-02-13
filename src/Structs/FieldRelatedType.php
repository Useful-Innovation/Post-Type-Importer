<?php

namespace GoBrave\PostTypeImporter\Structs;

use GoBrave\PostTypeImporter\Structs\Field;

class FieldRelatedType extends Field
{
  protected $default_options = [
    'post_type'   => null,
    'field_order' => 'title',
    'order'       => 'asc',
    'notype'      => null
  ];

  protected function mergeOptions($options) {
    if(!isset($options['post_type'])) {
      throw new \InvalidArgumentException('Field of type related_type must have an option key named \'post_type\' with a valid post type name as string');
    }
    $options = parent::mergeOptions($options);
    if($options['order'] !== 'asc' AND $options['order'] !== 'desc') {
      throw new \InvalidArgumentException('Field of type related_type must have an option key named \'post_type\' with value \'asc\' or \'desc\'');
    }
    return $options;
  }
}
