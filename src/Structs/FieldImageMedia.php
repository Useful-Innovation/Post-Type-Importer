<?php

namespace GoBrave\PostTypeImporter\Structs;

class FieldImageMedia extends Field
{
  protected $default_options = [
    'css_class'  => 'magic_fields',
    'max_height' => '',
    'max_width'  => '',
    'custom'     => '',
    'image_size' => null
  ];

  protected function mergeOptions($options) {
    if(!isset($options['image_size']) OR !($options['image_size'] instanceof ImageSize)) {
      throw new \InvalidArgumentException('Field of type image_media must have an option key named \'image_size\' with a string value and as valid image size');
    }
    return parent::mergeOptions($options);
  }

  public function toMagicFields() {
    $array = parent::toMagicFields();
    $label = rtrim(rtrim($array['label']), '.');
    if($this->options['image_size']->isSquare()) {
      $label .= $this->imageSquareLabel();
    } else if($this->options['image_size']->isLandscape()) {
      $label .= $this->imageHorizontalLabel();
    } else {
      $label .= $this->imageVerticalLabel();
    }
    $array['label'] = $label;
    return $array;
  }

  protected function optionsToMagicFields() {
    $options = $this->options;
    $options['image_size'] = $options['image_size']->getName();
    return $options;
  }

  private function imageSquareLabel() {
    return sprintf(
      '. Välj en kvadratisk bild med sidan minst %d pixlar.',
      $this->options['image_size']->getWidth()
    );
  }

  private function imageHorizontalLabel($part = 'liggande') {
    return sprintf(
      '. Välj en %s bild. Minst %d pixlar bred och %d pixlar hög.',
      $part,
      $this->options['image_size']->getWidth(),
      $this->options['image_size']->getHeight()
    );
  }

  private function imageVerticalLabel() {
    return $this->imageHorizontalLabel('stående');
  }
}
