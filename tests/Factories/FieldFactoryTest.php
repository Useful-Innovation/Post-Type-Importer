<?php

use GoBrave\PostTypeImporter\Factories\FieldFactory;

class FieldFactoryTest extends TestCase
{

  /**
  * @dataProvider differentFields
  */
  public function testCreate($data, $class) {
    $factory = new FieldFactory($this->getNamespace(), DATA::$image_sizes);
    $field   = $factory->create($data);

    $this->assertTrue($field instanceof $class, 'Checking that field of type ' . $data->type . ' is of ' . $class);
  }



  public function differentFields() {
    $data = $this->getData();
    $set  = [];
    foreach($data->groups[0]->fields as $tmp) {
      $set[] = [$tmp, $this->typeToClass($tmp->type)];
    }

    return $set;
  }

  private function getNamespace() {
    return 'GoBrave\\PostTypeImporter\\Structs\\';
  }

  private function typeToClass($type) {
    $base  = $this->getNamespace();
    $class = 'Field';
    if($type == 'textbox') {
      $class = 'FieldTextBox';
    } else if($type == 'image') {
      $class = 'FieldImage';
    } else if($type == 'markdown_editor') {
      $class = 'FieldMarkdownEditor';
    } else if($type == 'checkbox_list') {
      $class = 'FieldCheckboxList';
    } else if($type == 'checkbox') {
      $class = 'FieldCheckbox';
    } else if($type == 'multiline') {
      $class = 'FieldMultiline';
    } else if($type == 'related_type') {
      $class = 'FieldRelatedType';
    } else if($type == 'file') {
      $class = 'FieldFile';
    } else if($type == 'dropdown') {
      $class = 'FieldDropdown';
    } else if($type == 'radiobutton_list') {
      $class = 'FieldRadiobuttonList';
    }

    return implode('', [$base, $class]);
  }
}
