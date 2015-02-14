<?php

namespace GoBrave\PostTypeImporter\Structs;

use stdClass;

abstract class Field
{
  protected $name;
  protected $title;
  protected $description;
  protected $duplicated;
  protected $required;
  protected $type;
  protected $options;

  protected $default_options = [];

  public function __construct($name, $title, $description, $duplicated, $required, $type, array $options) {
    $this->name        = $name;
    $this->title       = $title;
    $this->description = $description;
    $this->duplicated  = $duplicated;
    $this->required    = $required;
    $this->type        = $type;
    $this->options     = $this->mergeOptions($options);
  }

  protected function mergeOptions($options) {
    return array_merge($this->default_options, $options);
  }

  public function getName() {
    return $this->name;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getDuplicated() {
    return $this->duplicated;
  }

  public function isDuplicatable() {
    return $this->getDuplicated();
  }

  public function getRequired() {
    return $this->required;
  }

  public function isRequired() {
    return $this->getRequired();
  }

  public function getType() {
    return $this->type;
  }

  public function getOptions() {
    return $this->options;
  }

  public function toMagicFields() {
    $array = [
      'name'           => $this->name,
      'label'          => $this->title,
      'description'    => $this->description,
      'type'           => $this->type,
      'required_field' => (int)$this->required,
      'duplicated'     => (int)$this->duplicated,
      'active'         => 1,
      'options'        => serialize($this->optionsToMagicFields())
    ];

    return $array;
  }

  protected function optionsToMagicFields() {
    return $this->options;
  }

}
