<?php

class FieldTextCase extends PHPUnit_Framework_TestCase
{
  protected function getData() {
    if(!isset($this->data)) {
      $this->data = json_decode(file_get_contents(__DIR__ . '/../_data/base.json'));
    }
    return $this->data;
  }

  protected function create($data, $class) {
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
}
