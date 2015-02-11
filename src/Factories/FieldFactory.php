<?php

namespace GoBrave\PostTypeImporter\Factories;

use GoBrave\PostTypeImporter\Structs\ImageSize;

class FieldFactory
{
  private $base_namespace;
  private $image_sizes;

  public function __construct($base_namespace, array $image_sizes) {
    $this->base_namespace = rtrim($base_namespace, '\\') . '\\';
    $this->image_sizes    = $image_sizes;
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
      $this->extendOptions($data->options)
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

  private function extendOptions($options) {
    if(isset($options->image_size) AND isset($this->image_sizes[$options->image_size])) {
      $options->image_size = $this->buildImageSize($options->image_size, $this->image_sizes[$options->image_size]);
    }

    return $options;
  }

  private function buildImageSize($name, $data) {
    return new ImageSize($name, $data['width'], $data['height'], $data['crop-mode']);
  }
}
