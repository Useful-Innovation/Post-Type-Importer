<?php

use GoBrave\PostTypeImporter\Factories\FieldFactory;

class FieldFactoryTest extends TestCase
{

  /**
  * @dataProvider differentFields
  */
  public function testCreate($type, $data, $class) {
    $factory = new FieldFactory($this->getNamespace(), DATA::$image_sizes);
    $field   = $factory->create($data);

    $this->assertTrue($field instanceof $class, 'Checking that field of type ' . $data->type . ' is of ' . $class);
  }



  public function differentFields() {
    $data = $this->getData();
    $set  = [];
    foreach($data->groups[0]->fields as $tmp) {
      $set[] = [$tmp->type, $tmp, $this->typeToClass($tmp->type)];
    }

    return $set;
  }
}
