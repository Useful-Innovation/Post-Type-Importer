<?php

require_once(__DIR__ . '/TestCase.php');

ini_set('xdebug.var_display_max_depth', 100);

class WPDB
{
  public $prefix = 'wp_';
  public static $counter = 0;
  public function __construct() {}

  public function get_results($sql) {
    self::$counter++;

    return $data;
  }
}

$wpdb = new WPDB();




class NullLogger implements GoBrave\Util\LoggerInterface
{
  public function success($str) {
    return null;
  }

  public function warning($str) {
    return null;
  }

  public function error($str) {
    return null;
  }

  public function info($str) {
    return null;
  }

}







class DATA
{
  public static $post_types = null;
  public static $image_sizes = [
    'featured-image' => [
      'width'  => 960,
      'height' => 540,
      'crop'   => true
    ],
    'facebook-og-image' => [
      'width'  => 254,
      'height' => 254,
      'crop'   => false
    ]
  ];
}

DATA::$post_types = [
  (object)[
    'id'          => 1,
    'type'        => 'ui_startpage',
    'name'        => 'Startsidan',
    'description' => '',
    'arguments'   => 'a:4:{s:4:"core";a:7:{s:2:"id";N;s:5:"label";s:10:"Startsidan";s:6:"labels";s:10:"Startsidan";s:4:"type";s:12:"ui_startpage";s:11:"description";s:0:"";s:8:"quantity";s:1:"0";s:14:"flush_rewrites";b:0;}s:7:"support";a:4:{s:5:"title";s:1:"1";s:6:"editor";s:1:"1";s:9:"revisions";s:1:"0";s:15:"page-attributes";s:1:"1";}s:6:"option";a:16:{s:6:"public";s:1:"1";s:18:"publicly_queryable";s:1:"1";s:19:"exclude_from_search";s:1:"0";s:7:"show_ui";s:1:"1";s:12:"show_in_menu";s:1:"1";s:13:"menu_position";s:0:"";s:15:"capability_type";s:4:"post";s:12:"hierarchical";s:1:"1";s:11:"has_archive";s:1:"0";s:16:"has_archive_slug";s:0:"";s:7:"rewrite";s:1:"1";s:12:"rewrite_slug";s:9:"startpage";s:10:"with_front";s:1:"0";s:9:"query_var";s:1:"1";s:10:"can_export";s:1:"1";s:17:"show_in_nav_menus";s:1:"1";}s:5:"label";a:13:{s:4:"name";s:10:"Startsidan";s:13:"singular_name";s:10:"Startsidan";s:7:"add_new";s:21:"Lägg till startsidan";s:9:"all_items";s:15:"Alla startsidan";s:12:"add_new_item";s:24:"Lägg till ny startsidan";s:9:"edit_item";s:19:"Redigera startsidan";s:8:"new_item";s:13:"Ny startsidan";s:9:"view_item";s:15:"Visa startsidan";s:12:"search_items";s:15:"Sök startsidan";s:9:"not_found";s:23:"Hittade inga startsidan";s:18:"not_found_in_trash";s:39:"Hittade inga startsidan i papperskorgen";s:17:"parent_item_colon";s:22:"Förälder: startsidan";s:9:"menu_name";s:10:"Startsidan";}}',
    'active'      => 1
  ],
  (object)[
    'id'          => 2,
    'type'        => 'ui_voice',
    'name'        => 'Röst',
    'description' => '',
    'arguments'   => 'a:4:{s:4:"core";a:7:{s:2:"id";N;s:5:"label";s:11:"Röst/citat";s:6:"labels";s:13:"Röster/citat";s:4:"type";s:8:"ui_voice";s:11:"description";s:0:"";s:8:"quantity";s:1:"0";s:14:"flush_rewrites";b:0;}s:7:"support";a:4:{s:5:"title";s:1:"1";s:6:"editor";s:1:"1";s:9:"revisions";s:1:"0";s:15:"page-attributes";s:1:"1";}s:6:"option";a:16:{s:6:"public";s:1:"1";s:18:"publicly_queryable";s:1:"0";s:19:"exclude_from_search";s:1:"1";s:7:"show_ui";s:1:"1";s:12:"show_in_menu";s:1:"1";s:13:"menu_position";s:0:"";s:15:"capability_type";s:4:"post";s:12:"hierarchical";s:1:"1";s:11:"has_archive";s:1:"0";s:16:"has_archive_slug";s:0:"";s:7:"rewrite";s:1:"1";s:12:"rewrite_slug";s:5:"voice";s:10:"with_front";s:1:"0";s:9:"query_var";s:1:"1";s:10:"can_export";s:1:"1";s:17:"show_in_nav_menus";s:1:"1";}s:5:"label";a:13:{s:4:"name";s:13:"Röster/citat";s:13:"singular_name";s:11:"Röst/citat";s:7:"add_new";s:22:"Lägg till röst/citat";s:9:"all_items";s:18:"Alla röster/citat";s:12:"add_new_item";s:25:"Lägg till ny röst/citat";s:9:"edit_item";s:20:"Redigera röst/citat";s:8:"new_item";s:14:"Ny röst/citat";s:9:"view_item";s:16:"Visa röst/citat";s:12:"search_items";s:18:"Sök röster/citat";s:9:"not_found";s:26:"Hittade inga röster/citat";s:18:"not_found_in_trash";s:42:"Hittade inga röster/citat i papperskorgen";s:17:"parent_item_colon";s:23:"Förälder: röst/citat";s:9:"menu_name";s:13:"Röster/citat";}}',
    'active'      => 1
  ]
];
