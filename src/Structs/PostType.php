<?php

namespace GoBrave\PostTypeImporter\Structs;

class PostType
{
  private $name;
  private $singular;
  private $plural;
  private $prefix;
  private $has_page;
  private $single;
  private $rewrite;
  private $groups;

  public function __construct($name, $singular, $plural, $prefix, $has_page, $single, $rewrite, array $groups) {
    $this->name     = $name;
    $this->singular = $singular;
    $this->plural   = $plural;
    $this->prefix   = $prefix;
    $this->has_page = (bool)$has_page;
    $this->single   = (bool)$single;
    $this->rewrite  = $rewrite;
    $this->groups   = $groups;
  }

  public function getName() {
    return $this->name;
  }

  public function getSingular() {
    return $this->singular;
  }

  public function getPlural() {
    return $this->plural;
  }

  public function getPrefix() {
    return $this->prefix;
  }

  public function getHasPage() {
    return $this->has_page;
  }

  public function getSingle() {
    return $this->single;
  }

  public function getRewrite() {
    return $this->rewrite;
  }

  public function getGroups() {
    return $this->groups;
  }

  public function toMagicFields() {
    $array = [
      'name'     => $this->name,
      'singular' => $this->singular,
      'plural'   => $this->plural,
      'prefix'   => $this->prefix,
      'has_page' => $this->has_page,
      'single'   => $this->single,
      'rewrite'  => $this->rewrite,
      'groups'   => []
    ];

    foreach($this->groups as $key => $group) {
      $array['groups'][] = $group->toMagicFields();
    }

    return $array;
  }
}
