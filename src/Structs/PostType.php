<?php

namespace GoBrave\PostTypeImporter\Structs;

class PostType
{
  private $name;
  private $singular;
  private $plural;
  private $prefix;
  private $has_page;
  private $single;
  private $rewrite;
  private $groups;

  public function __construct($name, $singular, $plural, $prefix, $has_page, $single, $rewrite, array $groups) {
    $this->name     = $name;
    $this->singular = $singular;
    $this->plural   = $plural;
    $this->prefix   = $prefix;
    $this->has_page = (bool)$has_page;
    $this->single   = (bool)$single;
    $this->rewrite  = $rewrite;
    $this->groups   = $groups;
  }

  public function getName() {
    return $this->name;
  }

  public function getSingular() {
    return $this->singular;
  }

  public function getPlural() {
    return $this->plural;
  }

  public function getPrefix() {
    return $this->prefix;
  }

  public function getHasPage() {
    return $this->has_page;
  }

  public function getSingle() {
    return $this->single;
  }

  public function getRewrite() {
    return $this->rewrite;
  }

  public function getGroups() {
    return $this->groups;
  }

  public function toMagicFields() {
    $array = [
      'type'      => $this->name,
      'name'      => $this->single ? $this->singular : $this->plural,
      'active'    => 1,
      'arguments' => serialize($this->buildArguments()),
      'groups'    => []
    ];

    foreach($this->groups as $key => $group) {
      $array['groups'][] = $group->toMagicFields();
    }

    return $array;
  }



  private function buildArguments() {
    $lc_singular = mb_strtolower($this->singular);
    $lc_plural   = mb_strtolower($this->plural);
    $lc_prefix   = mb_strtolower($this->prefix);

    if($this->has_page) {
      $publicly_queryable = '1';
      $exclude_from_search = '0';
    } else {
      $publicly_queryable = '0';
      $exclude_from_search = '1';
    }

    $args = [
      'core'    => [
        'label'          => $this->singular,
        'labels'         => $this->plural,
        'type'           => $this->name,
        'description'    => '',
        'quantity'       => '0',
        'flush_rewrites' => true,
      ],
      'support' => [
        'title'           => '1',
        'editor'          => '1',
        'page-attributes' => '1',
      ],
      'option'  => [
        'public'              => '1',
        'publicly_queryable'  => $publicly_queryable,
        'exclude_from_search' => $exclude_from_search,
        'show_ui'             => '1',
        'show_in_menu'        => '1',
        'menu_position'       => '',
        'capability_type'     => 'post',
        'hierarchical'        => '1',
        'has_archive'         => '0',
        'has_archive_slug'    => '',
        'rewrite'             => $this->rewrite ? '1' : '0',
        'rewrite_slug'        => $this->rewrite ?: '',
        'with_front'          => '0',
        'query_var'           => '1',
        'can_export'          => '1',
        'show_in_nav_menus'   => '1'
      ],
      'label'   => [
        'name'               => $this->plural,
        'singular_name'      => $this->singular,
        'add_new'            => 'Lägg till ' . $lc_singular,
        'all_items'          => 'Alla ' . $lc_plural,
        'add_new_item'       => 'Lägg till ' . $lc_prefix . ' ' . $lc_singular,
        'edit_item'          => 'Redigera ' . $lc_singular,
        'new_item'           => $this->prefix . ' ' . $lc_singular,
        'view_item'          => 'Visa ' . $lc_singular,
        'search_items'       => 'Sök ' . $lc_plural,
        'not_found'          => 'Hittade inga ' . $lc_plural,
        'not_found_in_trash' => 'Hittade inga ' . $lc_plural . ' i papperskorgen',
        'parent_item_colon'  => 'Förälder: ' . $this->singular,
        'menu_name'          => $this->plural
      ]
    ];

    return $args;
  }
}
