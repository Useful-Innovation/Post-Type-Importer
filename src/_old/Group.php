<?php

namespace GoBrave\PostTypeImporter;

class Group
{
  public static function createOrUpdate($values) {
    global $wpdb;

    if(self::exists($values->post_type, $values->name)) {
      return self::update($values);
    } else {
      return self::create($values);
    }
  }

  private static function id($post_type, $name) {
    global $wpdb;

    $sql = $wpdb->prepare("
      SELECT
        id
      FROM
        " . PostTypeImporter::GROUPS_TABLE . "
      WHERE
        name = %s
        AND
        post_type = %s
    ", $name, $post_type);

    return $wpdb->get_var($sql);
  }

  public static function exists($post_type, $name) {
    return (bool)self::id($post_type, $name);
  }

  public static function update($values) {
    global $wpdb;

    $id = self::id($values->post_type, $values->name);

    $sql = $wpdb->prepare("
      UPDATE
        " . PostTypeImporter::GROUPS_TABLE . "
      SET
        name       = %s,
        label      = %s,
        post_type  = %s,
        duplicated = %d
      WHERE
        id = %d
    ", 
      $values->name,
      $values->label,
      $values->post_type,
      $values->duplicated,
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
        " . PostTypeImporter::GROUPS_TABLE . "
      SET
        name       = %s,
        label      = %s,
        post_type  = %s,
        duplicated = %d,
        expanded   = 1
    ", $values->name, $values->label, $values->post_type, $values->duplicated);

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
        " . PostTypeImporter::GROUPS_TABLE . "
      WHERE
        post_type = '" . $post_type . "' 
    ");
  }

  public static function delete($id) {
    global $wpdb;

    $sql = $wpdb->prepare("
      DELETE FROM
        " . PostTypeImporter::GROUPS_TABLE . "
      WHERE
        id = %d
    ", $id);

    return $wpdb->query($sql);
  }

  public static function cleanUp($ids, $post_type) {
    global $wpdb;

    $sql = $wpdb->prepare("
      SELECT
        id
      FROM
        " . PostTypeImporter::GROUPS_TABLE . "
      WHERE
        id NOT IN ('" . implode("','", $ids) . "')
        AND
        post_type = %s
    ", $post_type);

    $res = $wpdb->get_results($sql);
    foreach($res as $row) {
      self::delete($row->id);
      FIeld::deleteForGroup($row->id);
    }
  }
}
