<?php

use GoBrave\PostTypeImporter\Structs\Group;

class GroupTest extends TestCase
{
  public function testGroup() {
    $fields = [$this->getFieldMock()];
    $group = new Group('info', 'Information', true, $fields);

    $this->assertSame($group->getName(), 'info');
    $this->assertSame($group->getTitle(), 'Information');
    $this->assertSame($group->getDuplicated(), true);
    $this->assertSame($group->isDuplicatable(), true);
    $this->assertSame($group->getFields(), $fields);
  }

  public function testToArray() {
    $fields = [$this->getFieldMock()];
    $group = new Group('info', 'Information', true, $fields);
    $array = $group->toMagicFields();

    $this->assertSame($array['name'], 'info');
    $this->assertSame($array['title'], 'Information');
    $this->assertSame($array['duplicated'], true);
    $this->assertTrue(is_array($array['fields']));
  }
}
