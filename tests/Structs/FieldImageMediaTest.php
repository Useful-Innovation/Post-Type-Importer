<?php

use GoBrave\PostTypeImporter\Structs\FieldImageMedia;
use GoBrave\PostTypeImporter\Structs\ImageSize;

class FieldImageMediaTest extends TestCase
{
  public $class = 'GoBrave\PostTypeImporter\Structs\FieldImageMedia';

  public function testDefaultOptions() {
    $mock = $this->imageSizeMock();
    $field = new FieldImageMedia(null, null, null, null, null, null, ['image_size' => $mock]);

    $options = $field->getOptions();
    $this->assertTrue($options == [
      'css_class'  => 'magic_fields',
      'max_height' => '',
      'max_width'  => '',
      'custom'     => '',
      'image_size' => $mock
    ]);
  }

  /**
  * @dataProvider imageTitles
  */
  public function testNameWithImageSizePortrait() {
    $mock = $this->imageSizeMock();
    $mock->method('isPortrait')
         ->willReturn(true);
    $mock->method('isLandscape')
         ->willReturn(false);
    $mock->method('isSquare')
         ->willReturn(false);

    $field = new FieldImageMedia(null, 'Bild', null, null, null, null, [
      'image_size' => new ImageSize('featured-image', 100, 500, true)
    ]);

    $array = $field->toMagicFields();

    $this->assertSame($array['label'], 'Bild. Välj en stående bild. Minst 100 pixlar bred och 500 pixlar hög.');
  }

  /**
  * @dataProvider imageTitles
  */
  public function testNameWithImageSizeLandscape() {
    $mock = $this->imageSizeMock();
    $mock->method('isPortrait')
         ->willReturn(false);
    $mock->method('isLandscape')
         ->willReturn(true);
    $mock->method('isSquare')
         ->willReturn(false);

    $field = new FieldImageMedia(null, 'Bild', null, null, null, null, [
      'image_size' => new ImageSize('featured-image', 500, 100, true)
    ]);

    $array = $field->toMagicFields();

    $this->assertSame($array['label'], 'Bild. Välj en liggande bild. Minst 500 pixlar bred och 100 pixlar hög.');
  }

  /**
  * @dataProvider imageTitles
  */
  public function testNameWithImageSizeSquare() {
    $mock = $this->imageSizeMock();
    $mock->method('isPortrait')
         ->willReturn(false);
    $mock->method('isLandscape')
         ->willReturn(false);
    $mock->method('isSquare')
         ->willReturn(true);

    $field = new FieldImageMedia(null, 'Bild', null, null, null, null, [
      'image_size' => new ImageSize('featured-image', 500, 500, true)
    ]);

    $array = $field->toMagicFields();

    $this->assertSame($array['label'], 'Bild. Välj en kvadratisk bild med sidan minst 500 pixlar.');
  }




  public function imageTitles() {
    return [
      ['Bild'],
      ['Bild.'],
      ['Bild. ']
    ];
  }
}
