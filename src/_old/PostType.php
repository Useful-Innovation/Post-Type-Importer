<?php

namespace GoBrave\PostTypeImporter;

class PostType
{
  public static function createOrUpdate($values) {
    global $wpdb;

    if(self::exists($values->type)) {
      return self::update($values);
    } else {
      return self::create($values);
    }
  }

  private static function id($post_type) {
    global $wpdb;

    $sql = $wpdb->prepare("
      SELECT
        id
      FROM
        " . PostTypeImporter::POST_TYPES_TABLE . "
      WHERE
        type = %s
    ", $post_type);

    return $wpdb->get_var($sql);
  }

  public static function exists($post_type) {
    return (bool)self::id($post_type);
  }

  public static function update($values) {
    global $wpdb;

    $id = self::id($values->type);

    $sql = $wpdb->prepare("
      UPDATE
        " . PostTypeImporter::POST_TYPES_TABLE . "
      SET
        type        = %s,
        name        = %s,
        description = %s,
        arguments   = %s,
        active      = %d
      WHERE
        id = %d
    ", 
      $values->type,
      $values->name,
      $values->description,
      serialize($values->arguments),
      $values->active,
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
        " . PostTypeImporter::POST_TYPES_TABLE . "
      SET
        type        = %s,
        name        = %s,
        description = %s,
        arguments   = %s,
        active      = %d
    ", 
      $values->type,
      $values->name,
      $values->description,
      serialize($values->arguments),
      $values->active
    );

    if($wpdb->query($sql) === false) {
      return false;
    } else {
      return $wpdb->insert_id;
    }
  }

  public static function delete($post_type) {
    global $wpdb;

    $wpdb->query("
      DELETE FROM
        " . PostTypeImporter::POST_TYPES_TABLE . "
      WHERE
        type = '" . $post_type . "' 
    ");
  }
}
