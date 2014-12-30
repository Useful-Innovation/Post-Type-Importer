<?php

namespace GoBrave\PostTypeImporter;

/**
 * A helper to generate, import and destroy custom post-types
 */
class Command extends \WP_CLI_Command
{
  private  function call($method, $args, $assoc_args) {
    $post_typr = new PostTypeImporter(new \GoBrave\Logger\WPCLI());
    $method = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $method))));
    if($method === 'destroy' AND in_array('all', $assoc_args)) {
      $post_typr->destroyAll();
    } else if($method === 'import' AND in_array('all', $assoc_args)) {
      $post_typr->importAll();
    } else {
      $pt = (@$assoc_args['pt'] ?: @$assoc_args['post_type']);
      $post_typr->{$method}($pt);
    }
  }
  
  /**
   * Imports a specific post-type
   * @synopsis --pt=<post-type>
   */
  public function import($a, $b) {
    $this->call('import', $a, $b);
  }
  
  /**
   * Imports all post-types
   * @synopsis
   */
  public function import_all($a, $b) {
    $this->call('import_all', $a, $b);
  }
  
  /**
   * Destroys a specific post-type
   * @synopsis --pt=<post-type>
   */
  public function destroy($a, $b) {
    $this->call('destroy', $a, $b);
  }
  
  /**
   * Destroys all post-types
   * @synopsis
   */
  public function destroy_all($a, $b) {
    $this->call('destroy_all', $a, $b);
  }
  
  /**
   * Rebuilds all post-types. This is equal to 'destroy_all' and 'import_all'
   * @synopsis
   */
  public function rebuild($a, $b) {
    $this->call('rebuild', $a, $b);
  }
  
  /**
   * Generates a basic JSON-file for a post-type
   * @synopsis --pt=<post-type>
   */
  public function generate($a, $b) {
    $this->call('generate', $a, $b);
  }
  
  /**
   * Flushes the rewrite-rules
   */
  public function flush() {
    flush_rewrite_rules(true);
  }
}

