<?php

namespace GoBrave\PostTypeImporter;

class Config
{
  private $post_types_path;

  public function __construct($settings = []) {
    if(count($settings) > 0) {
      foreach($this as $key => $value) {
        if(isset($settings[$key])) {
          $this->{$key} = $settings[$key];
        }
      }
    }
  }

  public function setPostTypesPath($post_types_path) {
    $this->post_types_path = $post_types_path;
  }

  public function getPostTypesPath() {
    return $this->post_types_path;
  }
}
