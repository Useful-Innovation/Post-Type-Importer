<?php

namespace GoBrave\PostTypeImporter\Structs;

class Group
{
  protected $name;
  protected $title;
  protected $duplicated;
  protected $fields;

  public function __construct($name, $title, $duplicated, array $fields) {
    $this->name       = $name;
    $this->title      = $title;
    $this->duplicated = $duplicated;
    $this->fields     = $fields;
  }


  public function getName() {
    return $this->name;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getDuplicated() {
    return $this->duplicated;
  }

  public function isDuplicatable() {
    return $this->getDuplicated();
  }

  public function getFields() {
    return $this->fields;
  }

  public function toMagicFields() {
    $array = [
      'name'       => $this->name,
      'label'      => $this->title,
      'duplicated' => $this->duplicated,
      'expanded'   => 1,
      'fields'     => []
    ];

    foreach($this->fields as $key => $field) {
      $array['fields'][] = $field->toMagicFields();
    }

    return $array;
  }
}
