<?php

use GoBrave\PostTypeImporter\Repository;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
  public function setUp() {
    global $wpdb;
    $this->wpdb = $wpdb;
  }

  public function testConstruct() {
    $obj = new Repository($this->wpdb);
    $this->assertTrue($obj instanceof Repository);
  }

  public function testSelect() {
    $stub = $this->mock('get_results', DATA::$post_types);
    $r    = $this->repo($stub);
    $res  = $r->select('*', 'mf_posttypes');

    $this->assertTrue(count($res) === 2);
    $this->assertTrue($res[0]->type === 'ui_startpage');
  }




  private function repo($wpdb) {
    return new Repository($wpdb);
  }

  private function mock($method, $data) {
    $stub = $this->getMockBuilder('WPDB')->getMock();
    $stub->method($method)
         ->willReturn($data);
    return $stub;
  }
}
