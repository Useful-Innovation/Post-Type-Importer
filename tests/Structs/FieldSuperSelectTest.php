<?php

use GoBrave\PostTypeImporter\Structs\FieldSuperSelect;

class FieldSuperSelectTest extends PHPUnit_Framework_TestCase
{
  public function testToMagicFields() {
    $post_types = ['product', 'category'];
    $field = new FieldSuperSelect(null, null, null, null, null, null, ['post_types' => $post_types]);

    $options = $field->getOptions();
    $this->assertTrue($options == [
      'post_types' => $post_types
    ]);

    $field = new FieldSuperSelect(null, null, null, null, null, null, []);
    $options = $field->getOptions();
    $this->assertTrue($options == [
      'post_types' => 'all'
    ]);
  }
}
