<?php

use GoBrave\PostTypeImporter\Structs\Field;

class FieldTest extends TestCase
{
  public function setUp() {
    $this->getData();
  }

  public function testConstruct() {
    $field = $this->createField($this->getData()->groups[0]->fields[0], 'GoBrave\PostTypeImporter\Structs\Field');

    $this->assertTrue($field instanceof Field, '$field is instance of Field');
  }

  public function testCustomOptions() {
    $data  = [
      'size'      => 200,
      'evalueate' => 1
    ];
    $field = new Field(null, null, null, null, null, null, $data);

    $options = $field->getOptions();
    $this->assertTrue($options == $data);
  }


  /**
  * @dataProvider fieldsFromFile
  */
  public function testValues($type, $data) {
    $field = $this->createField($data, $this->typeToClass($data->type));

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

  /**
   * @dataProvider fieldsWithOptionsFromFile
   * @expectedException InvalidArgumentException
   */
  public function testValuesWithoutOptions($type, $data) {
    $data->options = new stdClass;
    $field = $this->createField($data, $this->typeToClass($data->type));
  }



  public function fieldsFromFile() {
    $data = $this->getData();
    $set  = [];
    foreach($data->groups[0]->fields as $tmp) {
      if($tmp->type == 'image_media') {
        $tmp->options->image_size = $this->imageSizeMock();
      }
      $set[] = [$tmp->type, $tmp];
    }
    return $set;
  }

  public function fieldsWithOptionsFromFile() {
    $fields_with_options = [
      'checkbox_list',
      'image_media'
    ];
    $data = $this->getData();
    $set  = [];
    foreach($data->groups[0]->fields as $tmp) {
      if(in_array($tmp->type, $fields_with_options)) {
        $set[] = [$tmp->type, $tmp];
      }
    }
    return $set;
  }
}
