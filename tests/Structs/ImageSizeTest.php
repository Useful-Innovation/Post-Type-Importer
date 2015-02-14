<?php

use GoBrave\PostTypeImporter\Structs\ImageSize;

class ImageSizeTest extends TestCase
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

  public function testSquare() {
    $image_size = new ImageSize(null, 500, 500, null);
    $this->assertTrue($image_size->isSquare());
  }

  public function testLandscape() {
    $image_size = new ImageSize(null, 500, 100, null);
    $this->assertTrue($image_size->isLandscape());
    $this->assertTrue($image_size->isHorizontal());
  }

  public function testPortrait() {
    $image_size = new ImageSize(null, 100, 500, null);
    $this->assertTrue($image_size->isPortrait());
    $this->assertTrue($image_size->isVertical());
  }
}
