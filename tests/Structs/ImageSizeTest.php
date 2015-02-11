<?php

use GoBrave\PostTypeImporter\Structs\ImageSize;

class ImageSizeTest extends PHPUnit_Framework_TestCase
{
  public function testValues() {
    $image_size = new ImageSize('featured-image', 500, 100, true);

    $this->assertSame('featured-image', $image_size->getName());
    $this->assertSame(500,   $image_size->getWidth());
    $this->assertSame(100,   $image_size->getHeight());
    $this->assertSame(false, $image_size->cropModeSoft());
    $this->assertSame(true,  $image_size->cropModeHard());
    $this->assertSame(true,  $image_size->getCropMode());
  }
}
