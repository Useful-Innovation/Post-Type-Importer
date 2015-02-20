<?php

namespace GoBrave\PostTypeImporter\Services;

use GoBrave\Util\LoggerInterface;
use GoBrave\PostTypeImporter\Factories\PostTypeFactory;

class Importer
{
  const PT_NAME_MAX_LENGTH = 20;

  private $repository;
  private $logger;
  private $json_dir;

  public function __construct(Repository $repository, LoggerInterface $logger, $json_dir) {
    $this->repository = $repository;
    $this->logger     = $logger;
    $this->json_dir   = $json_dir;
  }

  public function import(PostTypeFactory $factory, $post_type) {

    if(strlen($post_type) > self::PT_NAME_MAX_LENGTH){
      $this->logger->error($post_type . ", name to long (max: " . self::PT_NAME_MAX_LENGTH . ")");
    }

    $post_type = $factory->create($this->getData($post_type));
    $this->repository->save($post_type);
    $this->logger->success('Post type ' . $post_type->getName() . ' imported');
  }

  public function destroy($post_type) {
    $this->repository->delete($post_type);
    $this->logger->success('Post type ' . $post_type . ' destroyed');
  }

  public function destroyAll() {
    $post_types = $this->repository->getPostTypes();
    foreach($post_types as $post_type) {
      $this->destroy($post_type);
    }
  }

  public function generate($post_type) {
    $file = $this->jsonFile($post_type);
    if(file_exists($file)) {
      $this->logger->error("JSON file for post type '" . $post_type . "' already exists.");
    }

    $struct = array(
      'name'     => $post_type,
      'singular' => ucwords($post_type),
      'plural'   => ucwords($post_type) . 's',
      'prefix'   => 'Ny',
      'has_page' => true,
      'single'   => false,
      'rewrite'  => $post_type,
      'groups'   => array()
    );

    file_put_contents($file, str_replace('    ', '  ', json_encode($struct, JSON_PRETTY_PRINT)));
    $this->logger->success("JSON file for post type '" . $post_type . "' created");
  }

  public function getPostTypes() {
    $post_types = [];
    foreach(glob($this->json_dir . '/*.json') as $file) {
      $post_types[] = pathinfo($file, PATHINFO_FILENAME);
    }
    return $post_types;
  }

  public function writeModelFile($dir, $post_type, $class_name) {
    $file = $dir . '/' . $class_name . '.php';

    if(file_exists($file)) { return; }

    $content = "<?php namespace App\PostTypes;\n\nuse App\Presenter;\n\nclass " . $class_name . " extends Presenter\n{\n  const POST_TYPE = '" . $post_type . "';\n}\n";

    $this->logger->success('Model for post type \'' . $post_type . '\' created');
    file_put_contents($file, $content);
  }


  //
  //
  //    Helpers
  //
  //
  private function getData($post_type) {
    $file = $this->jsonFile($post_type);
    if(!file_exists($file)) {
      $this->logger->error('Post type \'' . $post_type . '\' does not exists');
    }
    $data = json_decode(file_get_contents($file));
    if(!$data) {
      $this->logger->error('Post type \'' . $post_type . '\' is not valid JSON');
    }

    return $data;
  }

  private function jsonFile($post_type) {
    return $this->json_dir . '/' . $post_type . '.json';
  }
}
