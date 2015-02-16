<?php

ini_set('xdebug.var_display_max_depth', 100);

require_once(__DIR__ . '/vendor/autoload.php');

use GoBrave\PostTypeImporter\Factories\PostTypeFactory;
use GoBrave\PostTypeImporter\Factories\GroupFactory;
use GoBrave\PostTypeImporter\Factories\FieldFactory;

$base = json_decode(file_get_contents(__DIR__ . '/tests/_data/base.json'));

$factory = new PostTypeFactory(
  new GroupFactory(
    new FieldFactory(
      'GoBrave\PostTypeImporter\Structs',
      [
        'featured-image' => [
          'width'     => 500,
          'height'    => 500,
          'crop-mode' => true
        ]
      ]
    )
  )
);

$pt = $factory->create($base);

var_dump($pt);

var_dump($pt->toMagicFields());
