<?php

namespace ToMagicFields;

use TestCase;
use GoBrave\PostTypeImporter\Structs\Group;

class GroupTest extends TestCase
{
  public function testGroup() {
    $field = $this->getFieldMock();
    $group = new Group('info', 'Information', false, [$field]);
    $array = $group->toMagicFields();

    $fields = $array['fields'];
    unset($array['fields']);
    $this->assertTrue($array == [
      'name'       => 'info',
      'label'      => 'Information',
      'duplicated' => false,
      'expanded'   => 1
    ], 'testing toMagicFields for Group');

    $this->assertTrue(is_array($fields));
  }
}
