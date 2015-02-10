<?php

namespace GoBrave\PostTypeImporter\Factories;

class FieldFactory
{
  private $base_namespace;

  public function __construct($base_namespace) {
    $this->base_namespace = rtrim($base_namespace, '\\') . '\\';
  }

  public function create($data) {
    $class = $this->typeToClass($data->type);
    return new $class(
      $data->name,
      $data->title,
      $data->description,
      $data->duplicated,
      $data->required,
      $data->type,
      $data->options
    );
  }

  private function typeToClass($type) {
    $class = '';

    if('textbox' === $type) {
      $class = 'Textbox';
    } else if('image_media' === $type) {
      $class = 'Image';
    } else if('markdown_editor' === $type) {
      $class = 'MarkdownEditor';
    }

    return implode('', [$this->base_namespace, $class, 'Field']);
  }
}
