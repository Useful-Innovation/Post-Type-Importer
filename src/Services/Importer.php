<?php

namespace GoBrave\PostTypeImporter\Services;

class Importer
{
  private $repository;
  private $logger;

  public function __construct(Repository $repository, LoggerInterface $logger) {
    $this->repository = $repository;
    $this->logger     = $logger;
  }

  public function import($data) {

  }

  public function delete($post_type) {
    return $this->repository->delete($post_type);
  }
}
