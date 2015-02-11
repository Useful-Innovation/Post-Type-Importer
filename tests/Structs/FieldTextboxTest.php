<?php

use GoBrave\PostTypeImporter\Structs\FieldTextbox;

class FieldTextboxTest extends FieldTextCase
{
  public $class = 'GoBrave\PostTypeImporter\Structs\FieldTextbox';

  public function testDefaultOptions() {
    $field = new FieldTextbox(null, null, null, null, null, null, []);

    $options = $field->getOptions();
    $this->assertTrue($options == [
      'evalueate' => 0,
      'size'      => 100
    ]);
  }

  public function testCustomOptions() {
    $data  = [
      'size'      => 200,
      'evalueate' => 1
    ];
    $field = new FieldTextbox(null, null, null, null, null, null, $data);

    $options = $field->getOptions();
    $this->assertTrue($options == $data);
  }

  public function testToArray() {
    $field = $this->create($this->getData()->groups[0]->fields[0], $this->class);
    $array = $field->toArray();

    $this->assertTrue($array == [
      'name'        => 'title',
      'title'       => 'Titel',
      'description' => 'a textbox',
      'duplicated'  => false,
      'required'    => false,
      'type'        => 'textbox',
      'options'     => [
        'size'      => 100,
        'evalueate' => 0
      ]
    ], 'Checking that the toArray representation of the FieldTextbox is correct');
  }
}
