<?php

use GoBrave\PostTypeImporter\Structs\PostType;

class PostTypeTest extends TestCase
{
  public function testConstruct() {
    $mock = $this->getGroupMock();
    $mock->method('toMagicFields')
         ->willReturn([]);
    $groups    = [$mock];
    $post_type = new PostType(
      'name',
      'singular',
      'plural',
      'prefix',
      true,
      true,
      'rewrite',
      $groups
    );

    $this->assertSame($post_type->getName(), 'name');
    $this->assertSame($post_type->getSingular(), 'singular');
    $this->assertSame($post_type->getPlural(), 'plural');
    $this->assertSame($post_type->getPrefix(), 'prefix');
    $this->assertSame($post_type->getHasPage(), true);
    $this->assertSame($post_type->getSingle(), true);
    $this->assertSame($post_type->getRewrite(), 'rewrite');
    $this->assertSame($post_type->getGroups(), $groups);
  }
}
