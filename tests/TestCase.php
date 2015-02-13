<?php

class TestCase extends PHPUnit_Framework_TestCase
{
  protected function getData() {
    if(!isset($this->data)) {
      $this->data = json_decode(file_get_contents(__DIR__ . '/_data/base.json'));
    }
    return $this->data;
  }

  protected function createField($data, $class) {
    return new $class(
      $data->name,
      $data->title,
      $data->description,
      $data->duplicated,
      $data->required,
      $data->type,
      (array)$data->options
    );
  }

  protected function getFieldMock() {
    return $this->getMockByClassName('Structs\Field');
  }

  protected function getFieldFactoryMock() {
    return $this->getMockByClassName('Factories\FieldFactory');
  }

  protected function getMockByClassName($class) {
    $class = $this->prependClass($class);
    return $this->getMockBuilder($class)
                ->disableOriginalConstructor()
                ->getMock();
  }

  private function prependClass($class) {
    return 'GoBrave\PostTypeImporter\\' . $class;
  }
}
