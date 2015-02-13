<?php

use GoBrave\PostTypeImporter\Structs\PostType;
use GoBrave\PostTypeImporter\Factories\PostTypeFactory;

class PostTypeFactoryTest extends TestCase
{
  public function testCreate() {
    $mock = $this->getMockByClass('Factories\GroupFactory');
    $mock->method('create')
         ->willReturn($this->getMockByClass('Structs\Group'));

    $factory   = new PostTypeFactory($mock);
    $post_type = $factory->create($this->getData());

    $this->assertTrue($post_type instanceof PostType);
  }





  private function getMockByClass($class) {
    $class = 'GoBrave\PostTypeImporter\\' . $class;
    return $this->getMockBuilder($class)
                ->disableOriginalConstructor()
                ->getMock();
  }
}
