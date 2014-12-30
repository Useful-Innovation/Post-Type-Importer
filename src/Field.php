<?php

namespace GoBrave\PostTypeImporter;

class Field
{
  public static function createOrUpdate($values) {
    global $wpdb;

    if(self::exists($values->post_type, $values->name, $values->custom_group_id)) {
      return self::update($values);
    } else {
      return self::create($values);
    }
  }

  private static function id($post_type, $name, $custom_group_id) {
    global $wpdb;

    $sql = $wpdb->prepare("
      SELECT
        id
      FROM
        " . PostTypeImporter::FIELDS_TABLE . "
      WHERE
        name = %s
        AND
        post_type = %s
        AND
        custom_group_id = %s
    ", $name, $post_type, $custom_group_id);

    return $wpdb->get_var($sql);
  }

  public static function exists($post_type, $name, $custom_group_id) {
    return (bool)self::id($post_type, $name, $custom_group_id);
  }

  public static function update($values) {
    global $wpdb;

    $id = self::id($values->post_type, $values->name, $values->custom_group_id);

    $sql = $wpdb->prepare("
      UPDATE
        " . PostTypeImporter::FIELDS_TABLE . "
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
      WHERE
        id = %d
    ", 
      $values->name,
      $values->label,
      $values->description,
      $values->post_type,
      $values->custom_group_id,
      $values->type,
      $values->required_field,
      $values->display_order,
      $values->duplicated,
      $values->active,
      $values->options,
      $id
    );

    if($wpdb->query($sql) === false) {
      return false;
    } else {
      return $id;
    }
  }

  public static function create($values) {
    global $wpdb;

    $sql = $wpdb->prepare("
      INSERT INTO
        " . PostTypeImporter::FIELDS_TABLE . "
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
      $values->name,
      $values->label,
      $values->description,
      $values->post_type,
      $values->custom_group_id,
      $values->type,
      $values->required_field,
      $values->display_order,
      $values->duplicated,
      $values->active,
      $values->options
    );

    if($wpdb->query($sql) === false) {
      return false;
    } else {
      return $wpdb->insert_id;
    }
  }

  public static function deleteForPostType($post_type) {
    global $wpdb;

    $wpdb->query("
      DELETE FROM
        " . PostTypeImporter::FIELDS_TABLE . "
      WHERE
        post_type = '" . $post_type . "' 
    ");
  }

  public static function deleteForGroup($custom_group_id) {
    global $wpdb;

    $wpdb->query("
      DELETE FROM
        " . PostTypeImporter::FIELDS_TABLE . "
      WHERE
        custom_group_id = '" . $custom_group_id . "' 
    ");
  }

  public static function cleanUp($ids, $post_type, $custom_group_id) {
    global $wpdb;

    $sql = $wpdb->prepare("
      DELETE FROM
        " . PostTypeImporter::FIELDS_TABLE . "
      WHERE
        id NOT IN ('" . implode("','", $ids) . "')
        AND
        post_type = %s
        AND
        custom_group_id = %d
    ", $post_type, $custom_group_id);

    return $wpdb->query($sql);
  }
}
