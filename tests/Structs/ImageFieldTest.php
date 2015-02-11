<?php

use GoBrave\PostTypeImporter\Structs\ImageField;

class ImageFieldTest extends PHPUnit_Framework_TestCase
{
  public function testImageAppendedTitle() {
    $field = new ImageField(null, 'En bild', null, null, null, (object)['image_size' => 'featured-image']);

    //$this->assertSame($field->getTitle(), 'En bild. Välj en liggande bild, minst 1200 pixlar bred och 800 pixlar hög');
  }
}
