<?php

use GoBrave\PostTypeImporter\Structs\Field;

class FieldTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    $this->getData();
  }

  public function testConstruct() {
    $field = $this->create($this->getData()->groups[0]->fields[0]);

    $this->assertTrue($field instanceof Field, '$field is instance of Field');
  }


  /**
  * @dataProvider fieldsFromFile
  */
  public function testValues($data) {
    $field = $this->create($data);

    $this->assertSame($data->name, $field->getName());
    $this->assertSame($data->title, $field->getTitle());
    $this->assertSame($data->description, $field->getDescription());
    $this->assertSame($data->duplicated, $field->getDuplicated());
    $this->assertSame($data->required, $field->getRequired());
    $this->assertSame($data->type, $field->getType());
    $this->assertTrue(is_array($field->getOptions()));

    // Aliases
    $this->assertSame($data->duplicated, $field->isDuplicatable());
    $this->assertSame($data->required, $field->isRequired());
  }


  public function fieldsFromFile() {
    $data = $this->getData();
    $set  = [];
    foreach($data->groups[0]->fields as $tmp) {
      $set[] = [$tmp];
    }
    return $set;
  }



  private function create($field) {
    return new Field(
      $field->name,
      $field->title,
      $field->description,
      $field->duplicated,
      $field->required,
      $field->type,
      (array)$field->options
    );
  }

  private function getData() {
    if(!isset($this->data)) {
      $this->data = json_decode(file_get_contents(__DIR__ . '/../_data/base.json'));
    }
    return $this->data;
  }
}
