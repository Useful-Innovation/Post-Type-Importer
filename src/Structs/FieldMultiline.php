<?php

namespace GoBrave\PostTypeImporter\Structs;

use GoBrave\PostTypeImporter\Structs\Field;

class FieldMultiline extends Field
{
  protected $default_options = [
    'hide_visual' => false,
    'height'      => 15,
    'width'       => 23
  ];
}
