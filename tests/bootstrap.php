<?php


class WPDB
{
  public $prefix = 'wp_';
  public static $counter = 0;
  public function __construct() {
    register_shutdown_function(function() {
        echo 'SQL Queries: ' . self::$counter . PHP_EOL;
    });
  }

  public function get_results($sql) {
    self::$counter++;

    return $data;
  }
}
