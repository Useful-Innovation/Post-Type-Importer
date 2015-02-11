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

  public function toArray() {
    $array = [
      'name'       => $this->name,
      'title'      => $this->title,
      'duplicated' => $this->duplicated,
      'fields'     => []
    ];

    foreach($this->fields as $key => $field) {
      $array['fields'][] = $field->toArray();
    }

    return $array;
  }
}
