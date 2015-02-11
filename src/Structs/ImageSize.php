<?php

namespace GoBrave\PostTypeImporter\Structs;

class ImageSize
{
  protected $name;
  protected $width;
  protected $height;
  protected $crop_mode;

  public function __construct($name, $width, $height, $crop_mode) {
    $this->name      = $name;
    $this->width     = $width;
    $this->height    = $height;
    $this->crop_mode = $crop_mode;
  }

  public function getName() {
    return $this->name;
  }

  public function getWidth() {
    return $this->width;
  }

  public function getHeight() {
    return $this->height;
  }

  public function getCropMode() {
    return $this->crop_mode;
  }

  public function cropModeSoft() {
    return $this->crop_mode === false;
  }

  public function cropModeHard() {
    return $this->crop_mode === true;
  }
}
