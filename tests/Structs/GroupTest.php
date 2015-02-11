<?php

use GoBrave\PostTypeImporter\Structs\Group;

class GroupTest extends PHPUnit_Framework_TestCase
{
  public function testGroup() {
    $group = new Group('info', 'Information', true, []);

    $this->assertSame($group->getName(), 'info');
    $this->assertSame($group->getTitle(), 'Information');
    $this->assertSame($group->getDuplicated(), true);
    $this->assertSame($group->isDuplicatable(), true);
    $this->assertSame($group->getFields(), []);
  }

  public function testToArray() {
    $group = new Group('info', 'Information', true, []);
    $array = $group->toArray();

    $this->assertSame($array['name'], 'info');
    $this->assertSame($array['title'], 'Information');
    $this->assertSame($array['duplicated'], true);
    $this->assertSame($array['fields'], []);
  }
}
