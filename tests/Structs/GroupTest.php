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
}
