<?php

namespace ToMagicFields;

use TestCase;

class FieldTest extends TestCase
{
  public function testToMagicFieldsForFieldTextBox() {
    $data    = $this->getData()->groups[0]->fields[0];
    $field   = $this->createField($data, $this->typeToClass($data->type));
    $array   = $field->toMagicFields();
    $options = unserialize($array['options']);

    $this->assertSame($array['name'], 'title');
    $this->assertSame($array['label'], 'Titel');
    $this->assertSame($array['description'], 'a textbox');
    $this->assertSame($array['duplicated'], 0);
    $this->assertSame($array['required_field'], 0);
    $this->assertSame($array['active'], 1);
    $this->assertSame($array['type'], 'textbox');
    $this->assertSame($options['size'], 100);
    $this->assertSame($options['evalueate'], 0);
  }

  public function testToMagicFieldsForFieldImageMedia() {
    $mock = $this->imageSizeMock();
    $mock->method('getName')
         ->willReturn('featured-image');
    $data  = $this->getData()->groups[0]->fields[2];
    $data->options->image_size = $mock;
    $field = $this->createField($data, $this->typeToClass($data->type));
    $array = $field->toMagicFields();

    $this->assertTrue($array == [
      'name'           => 'image',
      'label'          => 'Bild. Välj en stående bild. Minst 0 pixlar bred och 0 pixlar hög.',
      'description'    => 'image',
      'duplicated'     => 1,
      'required_field' => 1,
      'active'         => 1,
      'type'           => 'image_media',
      'options'        => serialize([
        'css_class'  => 'magic_fields',
        'max_height' => '',
        'max_width'  => '',
        'custom'     => '',
        'image_size' => 'featured-image'
      ])
    ], 'Checking that the toMagicFields representation of the FieldImageMedia is correct');
  }

  public function testToMagicFieldsForFieldSuperSelect() {
    $data  = $this->getData()->groups[0]->fields[10];
    $field = $this->createField($data, $this->typeToClass($data->type));
    $array = $field->toMagicFields();

    $this->assertSame($array['name'], 'super_select_1');
    $this->assertSame($array['label'], 'SuperSelect');
    $this->assertSame($array['type'], 'textbox', 'SuperSelect field is not masquerading as a textbox field');

    $options = unserialize($array['options']);
    $this->assertSame($options['post_types'], 'all');
    $this->assertSame($options['force_type'], 'related_type', 'SuperSelect field is not forcing the related_type type');
  }
}
