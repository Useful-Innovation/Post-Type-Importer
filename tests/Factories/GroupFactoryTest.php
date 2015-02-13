<?php

use GoBrave\PostTypeImporter\Factories\GroupFactory;
use GoBrave\PostTypeImporter\Structs\Group;

class GroupFactoryTest extends TestCase
{
  public function testConstruct() {
    $mock    = $this->getFieldFactoryMock();
    $mock->method('create')
         ->willReturn($this->getFieldMock());
    $factory = new GroupFactory($mock);
    $group   = $factory->create($this->getData()->groups[0]);

    $this->assertTrue($group instanceof Group);
  }



}

  //   $stub = $this->getMockBuilder('WPDB')->getMock();
  //   $stub->method($method)
  //        ->willReturn($data);
  //   return $stub;
