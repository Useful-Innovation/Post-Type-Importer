<?php

use GoBrave\PostTypeImporter\Structs\FieldImageMedia;

class FieldImageMediaTest extends TestCase
{
  public $class = 'GoBrave\PostTypeImporter\Structs\FieldImageMedia';

  public function testDefaultOptions() {
    $mock = $this->imageSizeMock();
    $field = new FieldImageMedia(null, null, null, null, null, null, ['image_size' => $mock]);

    $options = $field->getOptions();
    $this->assertTrue($options == [
      'css_class'  => 'magic_fields',
      'max_height' => '',
      'max_width'  => '',
      'custom'     => '',
      'image_size' => $mock
    ]);
  }

  public function testToArray() {
    $mock = $this->imageSizeMock();
    $data  = $this->getData()->groups[0]->fields[2];
    $data->options->image_size = $mock;
    $field = $this->createField($data, $this->class);
    $array = $field->toMagicFields();

    $this->assertTrue($array == [
      'name'        => 'image',
      'title'       => 'Bild',
      'description' => 'image',
      'duplicated'  => true,
      'required'    => true,
      'type'        => 'image_media',
      'options'     => [
        'css_class'  => 'magic_fields',
        'max_height' => '',
        'max_width'  => '',
        'custom'     => '',
        'image_size' => 'featured-image'
      ]
    ], 'Checking that the toArray representation of the FieldImageMedia is correct');
  }
}
