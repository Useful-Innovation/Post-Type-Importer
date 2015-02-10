<?php

namespace GoBrave\PostTypeImporter\Structs;

use stdClass;

class Field
{
  private $name;
  private $title;
  private $description;
  private $duplicated;
  private $required;
  private $type;
  private $options;

  public function __construct($name, $title, $description, $duplicated, $required, $type, stdClass $options = null) {
    $this->name        = $name;
    $this->title       = $title;
    $this->description = $description;
    $this->duplicated  = $duplicated;
    $this->required    = $required;
    $this->type        = $type;
    $this->options     = $options;
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

}
