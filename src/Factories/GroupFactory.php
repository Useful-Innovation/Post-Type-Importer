<?php

namespace GoBrave\PostTypeImporter\Factories;

use GoBrave\PostTypeImporter\Structs\Group;

class GroupFactory
{
  private $field_factory;

  public function __construct(FieldFactory $field_factory) {
    $this->field_factory = $field_factory;
  }

  public function create($data) {
    $fields = $this->createFields($data->name, $data->fields);
    return new Group(
      $data->name,
      $data->title,
      $data->duplicated,
      $fields
    );
  }

  private function createFields($base_name, $fields_data) {
    $fields = [];
    foreach($fields_data as $data) {
      $data->name = implode('_', [$base_name, $data->name]);
      $fields[] = $this->field_factory->create($data);
    }
    return $fields;
  }
}
