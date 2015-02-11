<?php

use GoBrave\PostTypeImporter\Factories\FieldFactory;

class FieldFactoryTest extends PHPUnit_Framework_TestCase
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
      $class = 'TextBoxField';
    } else if($type == 'image') {
      $class = 'ImageField';
    } else if($type == 'markdown_editor') {
      $class = 'MarkdownEditorField';
    }

    return implode('', [$base, $class]);
  }

  private function getData() {
    if(!isset($this->data)) {
      $this->data = json_decode(file_get_contents(__DIR__ . '/../_data/base.json'));
    }
    return $this->data;
  }
}
