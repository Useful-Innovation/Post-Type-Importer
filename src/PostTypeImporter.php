<?php

namespace GoBrave\PostTypeImporter;

use GoBrave\Util\MF_FIELD_TYPE;
use GoBrave\Util\LoggerInterface;
use GoBrave\Util\CaseConverter;
use GoBrave\Util\CropMode;
use GoBrave\Util\IWP;

class PostTypeImporter
{
  const POST_TYPES_TABLE = 'wp_mf_posttypes';
  const GROUPS_TABLE     = 'wp_mf_custom_groups';
  const FIELDS_TABLE     = 'wp_mf_custom_fields';

  const PT_NAME_MAX_LENGTH = 20;

  private $logger;
  private $case_converter;
  private $wp;
  private $config;

  public function __construct(LoggerInterface $logger, CaseConverter $case_converter, IWP $wp, Config $config) {
    $this->logger         = $logger;
    $this->case_converter = $case_converter;
    $this->wp             = $wp;
    $this->config         = $config;
  }

  //
  //
  //      Public interface
  //
  //
  public function import($post_type) {
    $file = $this->filePath($post_type);
    if(!file_exists($file)) {
      $this->logger->error("JSON file for post-type '" . $post_type . "' does not exists");
      return;
    }

    if(strlen($post_type) > self::PT_NAME_MAX_LENGTH){
      $this->logger->warning($post_type . ", name to long (max: " . self::PT_NAME_MAX_LENGTH . ")");
      return;
    }

    $struct = json_decode(file_get_contents($file));

    if(!$struct) {
      $this->logger->error("JSON format for post-type '" . $post_type . "' is invalid");
      return;
    }

    $pt_arguments = $this->argumentsForPostType($struct);

    if($post_type != 'post' AND $post_type != 'page') {
      $this->importPostType($struct, $pt_arguments);
    }
    $this->importGroups($struct->name, $struct->groups);
    $this->writeModelFile($post_type, $this->snakeToCamel($post_type));
    flush_rewrite_rules(true);

    $this->logger->success("Post type '" . $post_type . "' imported");
  }

  public function generate($post_type) {
    $file = $this->filePath($post_type);
    if(file_exists($file)) {
      $this->logger->error("JSON file for post type '" . $post_type . "' already exists.");
      return false;
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
    return true;
  }

  public function importAll() {
    $files = glob($this->basePath() . '/*.json');

    foreach($files as $file) {
      $this->import(pathinfo($file, PATHINFO_FILENAME));
    }
  }

  public function destroy($post_type) {
    global $wpdb;

    Field::deleteForPostType($post_type);
    Group::deleteForPostType($post_type);
    PostType::delete($post_type);

    $this->logger->success("Post type '" . $post_type . "' destroyed");
  }

  public function destroyAll() {
    global $wpdb;

    $sql = $wpdb->prepare("
      SELECT
        type
      FROM
        " . PostTypeImporter::POST_TYPES_TABLE . "
    ", null);

    $res = $wpdb->get_results($sql);

    foreach($res as $post_type) {
      $this->destroy($post_type->type);
    }
  }










  //
  //
  //    Helpers
  //
  //
  private function writeModelFile($post_type, $class_name) {
    $file = GR_APP_PATH . '/PostTypes/' . $class_name . '.php';

    if(file_exists($file)) { return; }

    $content = "<?php namespace App\PostTypes;\n\nuse App\Presenter;\n\nclass " . $class_name . " extends Presenter\n{\n  const POST_TYPE = '" . $post_type . "';\n}\n";

    $this->logger->success('Model for post type \'' . $post_type . '\' created');
    file_put_contents($file, $content);
  }

  private function basePath() {
    return $this->config->getPostTypesPath();
  }

  private function filePath($post_type) {
    return $this->basePath() . '/' . $post_type . '.json';
  }

  private function argumentsForPostType($struct) {
    $pt_arguments = array();

    $pt_arguments['core'] = array(
      'id'             => null,
      'label'          => $struct->singular,
      'labels'         => $struct->plural,
      'type'           => $struct->name,
      'description'    => '',
      'quantity'       => '0',
      'flush_rewrites' => true
    );

    $pt_arguments['support'] = array(
      'title'           => '1',
      'editor'          => '1',
      'revisions'       => '0',
      'page-attributes' => '1'
    );

    $pt_arguments['option'] = array(
      'public'              => '1',
      'publicly_queryable'  => $struct->has_page ? '1' : '0',
      'exclude_from_search' => $struct->has_page ? '0' : '1',
      'show_ui'             => '1',
      'show_in_menu'        => '1',
      'menu_position'       => '',
      'capability_type'     => 'post',
      'hierarchical'        => '1',
      'has_archive'         => '0',
      'has_archive_slug'    => '',
      'rewrite'             => $struct->rewrite ? '1' : '0',
      'rewrite_slug'        => $struct->rewrite ?: '',
      'with_front'          => '0',
      'query_var'           => '1',
      'can_export'          => '1',
      'show_in_nav_menus'   => '1'
    );

    $lc_singular = mb_strtolower($struct->singular);
    $lc_plural   = mb_strtolower($struct->plural);
    $lc_prefix   = mb_strtolower($struct->prefix);

    $pt_arguments['label'] = array(
      'name'               => $struct->plural,
      'singular_name'      => $struct->singular,
      'add_new'            => 'Lägg till ' . $lc_singular,
      'all_items'          => 'Alla ' . $lc_plural,
      'add_new_item'       => 'Lägg till ' . $lc_prefix . ' ' . $lc_singular,
      'edit_item'          => 'Redigera ' . $lc_singular,
      'new_item'           => $struct->prefix . ' ' . $lc_singular,
      'view_item'          => 'Visa ' . $lc_singular,
      'search_items'       => 'Sök ' . $lc_plural,
      'not_found'          => 'Hittade inga ' . $lc_plural,
      'not_found_in_trash' => 'Hittade inga ' . $lc_plural . ' i papperskorgen',
      'parent_item_colon'  => 'Förälder: ' . $lc_singular,
      'menu_name'          => $struct->plural
    );

    return $pt_arguments;
  }

  private function importPostType($struct, $arguments) {
    global $wpdb;

    $post_type = new \stdClass();
    $post_type->type        = $struct->name;
    $post_type->name        = $struct->singular;
    $post_type->description = '';
    $post_type->arguments   = $arguments;
    $post_type->active      = true;

    return PostType::createOrUpdate($post_type);
  }

  private function importGroups($post_type, $groups) {
    if(!is_array($groups)) return false;
    $ids = array();
    foreach($groups as $group) {
      $id = $this->importGroup($post_type, $group);
      if($id) {
        $ids[] = $id;
      }
    }

    Group::cleanUp($ids, $post_type);
  }

  private function importGroup($post_type, $group) {
    global $wpdb;

    if(!$group->fields OR !is_array($group->fields) OR count($group->fields) == 0) {
      $this->logger->warning("Group '" . $group->name . "' got no fields, it won't be imported");
      return false;
    }

    $fields = $group->fields;
    unset($group->fields);
    $group->post_type = $post_type;
    $group->label     = $group->title;

    $id = Group::createOrUpdate($group);

    $this->importFields($post_type, $id, $group->name, $fields);

    return $id;
  }

  private function importFields($post_type, $group_id, $group_name, $fields) {
    if(!is_array($fields)) return false;
    $ids   = array();
    $order = 0;
    foreach($fields as $field) {
      $id = $this->importField($post_type, $group_id, $group_name, $field, $order);
      if($id) {
        $ids[] = $id;
        $order++;
      }
    }

    Field::cleanUp($ids, $post_type, $group_id);
  }

  private function importField($post_type, $group_id, $group_name, $field, $display_order) {
    global $wpdb;

    $object = new \stdClass();
    $object->name            = implode('_', array($group_name, $field->name));
    $object->label           = $field->title;
    $object->description     = $field->description;
    $object->post_type       = $post_type;
    $object->custom_group_id = $group_id;
    $object->type            = $field->type;
    $object->required_field  = $field->required;
    $object->display_order   = $display_order;
    $object->duplicated      = $field->duplicated;
    $object->active          = true;
    $object->options         = $this->optionsForType($field->type, $field->options);

    if($field->type == MF_FIELD_TYPE::IMAGE_MEDIA) {
      $object->label = $this->appendImageSize($object, @$field->options->image_size);
    }

    return Field::createOrUpdate($object);
  }

  private function optionsForType($type, $options) {
    $tmp = (array)$options;

    if($type == MF_FIELD_TYPE::TEXTBOX) {
      $options = array(
        'evalueate' => isset($options->max_length) ? 1 : 0,
        'size'      => isset($options->max_length) ? $options->max_length : 100
      );
    } else if($type == MF_FIELD_TYPE::IMAGE_MEDIA) {
      $options = array(
        'css_class'  => 'magic_fields',
        'max_height' => '',
        'max_width'  => '',
        'custom'     => ''
      );
    } else if($type == MF_FIELD_TYPE::MULTILINE) {
      $options = array(
        'hide_visual' => 0,
        'height'      => 15,
        'width'       => 23
      );
    } else if($type == MF_FIELD_TYPE::RELATED_TYPE) {
      $options = array(
        'post_type'   => $options->post_type,
        'field_order' => 'title',
        'order'       => 'asc',
        'notype'      => ''
      );
    } else if($type == MF_FIELD_TYPE::DROPDOWN) {
      $options = array(
        'options'       => implode("\n", $options->values),
        'multiple'      => '0',
        'default_value' => ''
      );
    } else if($type == MF_FIELD_TYPE::CHECKBOX_LIST) {
      $options = array(
        'options'       => implode("\n", $options->values),
        'default_value' => ''
      );
    } else if($type == MF_FIELD_TYPE::RADIOBUTTON_LIST) {
      $options = array(
        'options'       => implode("\n", $options->values),
        'default_value' => ''
      );
    } else {
      $options = array();
    }

    $options = array_merge($options, $tmp);

    if($options) {
      return serialize($options);
    } else {
      return serialize(array());
    }
  }

  private function appendImageSize($field, $image_size = null) {
    if(!$image_size) {
      return $field->label;
    }

    $size = \ui_get_image_size_by_name($image_size);

    if(!$size) {
      $this->logger->warning("Image size '" . $image_size . "' for field '" . $field->name . "' in post type '" . $field->post_type . "' does not exists.");
      return $field->label;
    }

    if($size['width'] == $size['height']) {
      // kvadratisk
      if($size['crop'] == CropMode::SOFT) {
        $field->label .= '. Välj en bild, där båda sidorna är minst ' . $size['width'] . ' pixlar';
      } else {
        $field->label .= '. Välj en kvadratisk bild, med minst sidan ' . $size['width'] . ' pixlar';
      }
    } else if($size['width'] > $size['height']) {
      // liggande
      $field->label .= '. Välj en liggande bild, minst ' . $size['width'] . ' pixlar bred och ' . $size['height'] . ' pixlar hög';
    } else {
      // stående
      $field->label .= '. Välj en stående bild, minst ' . $size['width'] . ' pixlar bred och ' . $size['height'] . ' pixlar hög';
    }

    return $field->label;
  }
}
