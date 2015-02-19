<?php

namespace GoBrave\PostTypeImporter\Factories;

class FactoryFactory
{
  public function build($images) {
    return new PostTypeFactory(
      new GroupFactory(
        new FieldFactory($images)
      )
    );
  }

  public static function create($images) {
    return (new self())->build($images);
  }
}
