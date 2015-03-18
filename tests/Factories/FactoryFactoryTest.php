<?php

use GoBrave\PostTypeImporter\Factories\FactoryFactory;
use GoBrave\PostTypeImporter\Factories\PostTypeFactory;

class FactoryFactoryTest extends TestCase
{
  public function testCreate() {
    $factory = new FactoryFactory();
    $factory = $factory->create([]);

    $this->assertTrue($factory instanceof PostTypeFactory);
  }
}
