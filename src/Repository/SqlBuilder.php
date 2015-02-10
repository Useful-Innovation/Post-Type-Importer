<?php

namespace GoBrave\PostTypeImporter\Repository;

class SqlBuilder
{
  public function setStatement($values) {
    $sql = [];
    foreach($values as $key => $value) {
      $sql[] = $key . " = '" . $value . "'";
    }
    return implode(', ', $sql);
  }

  public function whereStatement($values) {
    $sql = [];
    foreach($values as $key => $value) {
      $sql[] = $key . " = '" . $value . "'";
    }
    return implode(' AND ', $sql);
  }
}
