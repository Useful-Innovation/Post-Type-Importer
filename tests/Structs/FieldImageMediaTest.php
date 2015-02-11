<?php

use GoBrave\PostTypeImporter\Structs\FieldImageMedia;

class FieldImageMediaTest extends FieldTextCase
{
  public $class = 'GoBrave\PostTypeImporter\Structs\FieldImageMedia';

  public function testDefaultOptions() {
    $field = new FieldImageMedia(null, null, null, null, null, null, []);

    $options = $field->getOptions();
    $this->assertTrue($options == [
      'css_class'  => 'magic_fields',
      'max_height' => '',
      'max_width'  => '',
      'custom'     => '',
      'image_size' => null
    ]);
  }

  public function testToArray() {
    $mock  = $this->getMockBuilder('GoBrave\PostTypeImporter\Structs\ImageSize')
                  ->setConstructorArgs(['featured-image', 100, 100, true])
                  ->getMock();
    $mock->method('getName')
         ->willReturn('featured-image');
    $data  = $this->getData()->groups[0]->fields[2];
    $data->options->image_size = $mock;
    $field = $this->create($data, $this->class);
    $array = $field->toArray();

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
