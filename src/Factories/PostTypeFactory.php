<?php

namespace GoBrave\PostTypeImporter\Factories;

use GoBrave\PostTypeImporter\Factories\GroupFactory;
use GoBrave\PostTypeImporter\Structs\PostType;

class PostTypeFactory
{
  private $group_factory;

  public function __construct(GroupFactory $group_factory) {
    $this->group_factory = $group_factory;
  }

  public function create($data) {
    $groups = $this->createGroups($data->groups);
    return new PostType(
      $data->name,
      $data->singular,
      $data->plural,
      $data->prefix,
      $data->has_page,
      $data->single,
      $data->rewrite,
      $groups
    );
  }

  private function createGroups($groups_data) {
    $groups = [];
    foreach($groups_data as $data) {
      $groups[] = $this->group_factory->create($data);
    }
    return $groups;
  }
}
