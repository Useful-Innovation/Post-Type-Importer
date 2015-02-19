<?php

namespace GoBrave\PostTypeImporter\Services;

use GoBrave\PostTypeImporter\Structs\PostType;
use wpdb;

class Repository
{
  const TABLE_POST_TYPES = 'wp_mf_posttypes';
  const TABLE_GROUPS     = 'wp_mf_custom_groups';
  const TABLE_FIELDS     = 'wp_mf_custom_fields';

  private $wpdb;

  public function __construct(wpdb $wpdb) {
    $this->wpdb = $wpdb;
  }

  public function save(PostType $post_type) {
    $this->delete($post_type->getName());
    $data = $post_type->toMagicFields();

    $this->savePostType($data);
    foreach($data['groups'] as $group) {
      $this->saveGroup($group, $data['type']);
    }
  }

  public function delete($name) {
    $this->wpdb->query("DELETE FROM " . self::TABLE_POST_TYPES . " WHERE type      = '" . $name . "'");
    $this->wpdb->query("DELETE FROM " . self::TABLE_GROUPS     . " WHERE post_type = '" . $name . "'");
    $this->wpdb->query("DELETE FROM " . self::TABLE_FIELDS     . " WHERE post_type = '" . $name . "'");
  }

  public function getPostTypes() {
    return $this->wpdb->get_col("SELECT type FROM wp_mf_posttypes");
  }




  private function savePostType($data) {
    $sql = $this->wpdb->prepare("
      INSERT INTO
        " . self::TABLE_POST_TYPES . "
      SET
        type        = %s,
        name        = %s,
        description = %s,
        arguments   = %s,
        active      = %d
    ", 
      $data['type'],
      $data['name'],
      $data['description'],
      $data['arguments'],
      $data['active']
    );

    return (bool)$this->wpdb->query($sql);
  }

  private function saveGroup($group, $post_type) {
    $sql = $this->wpdb->prepare("
      INSERT INTO
        " . self::TABLE_GROUPS . "
      SET
        name       = %s,
        label      = %s,
        post_type  = %s,
        duplicated = %d,
        expanded   = %d
    ", 
      $group['name'],
      $group['label'],
      $post_type,
      $group['duplicated'],
      $group['expanded']
    );

    $this->wpdb->query($sql);
    $group_id = $this->wpdb->insert_id;
    foreach($group['fields'] as $key => $field) {
      $this->saveField($field, $group_id, $group['name'], $post_type, $key);
    }
  }

  private function saveField($field, $group_id, $group_name, $post_type, $display_order) {
    $sql = $this->wpdb->prepare("
      INSERT INTO
        " . self::TABLE_FIELDS . "
      SET
        name            = %s,
        label           = %s,
        description     = %s,
        post_type       = %s,
        custom_group_id = %d,
        type            = %s,
        required_field  = %d,
        display_order   = %d,
        duplicated      = %d,
        active          = %d,
        options         = %s
    ", 
      $field['name'],
      $field['label'],
      $field['description'],
      $post_type,
      $group_id,
      $field['type'],
      $field['required_field'],
      $display_order,
      $field['duplicated'],
      $field['active'],
      $field['options']
    );

    return (bool)$this->wpdb->query($sql);
  }
}
