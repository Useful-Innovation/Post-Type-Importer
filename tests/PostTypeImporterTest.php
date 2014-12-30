<?php

use GoBrave\PostTypeImporter\PostTypeImporter;
use GoBrave\Util\NullLogger;
use GoBrave\Util\CaseConverter;

class PostTypeImporterTest extends PHPUnit_Framework_TestCase
{
  public $startpage_file = __DIR__ . '/generated/startpage.json';

  public function testConstruct() {
    $importer = new PostTypeImporter(
      new GoBrave\Util\NullLogger(),
      new GoBrave\Util\CaseConverter(),
      new GoBrave\PostTypeImporter\Config([
        'post_types_path' => __DIR__ . '/generated'
      ])
    );

    $this->assertTrue($importer instanceof PostTypeImporter);

    $res1 = $importer->generate('startpage');
    $res2 = $importer->generate('startpage');
    $this->assertTrue(file_exists($this->startpage_file));
    $this->assertTrue($res1, 'Generation success');
    $this->assertFalse($res2, 'Check that file is not overwritten');
  }


  public function tearDown() {
    @unlink($this->startpage_file);
  }
}
