<?php

namespace GoBrave\PostTypeImporter\Factories;

class FactoryFactory
{
  public function create($images) {
    return new PostTypeFactory(
      new GroupFactory(
        new FieldFactory($images)
      )
    );
  }
}
