<?php namespace GoBrave\PostTypeImporter;

use WPDB;

class Repository
{
  private $wpdb;

  public function __construct(WPDB $wpdb) {
    $this->wpdb = $wpdb;
  }

  public function select($fields, $table) {
    return $this->wpdb->get_results("SELECT $fields FROM $table");
  }
}
