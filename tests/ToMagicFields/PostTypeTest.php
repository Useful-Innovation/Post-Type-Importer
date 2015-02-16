<?php

namespace ToMagicFields;

use TestCase;
use GoBrave\PostTypeImporter\Structs\PostType;

class PostTypeTest extends TestCase
{
  public function testPostType() {
    $pt = new PostType('product', 'Produkt', 'Produkter', 'Ny', true, false, 'product', []);
    $array = $pt->toMagicFields();

    $this->assertSame($array['type'], 'product');
    $this->assertSame($array['name'], 'Produkter');
    $this->assertSame($array['active'], 1);
    $this->assertTrue(is_array($array['groups']));

    $args = unserialize($array['arguments']);

    $this->assertSame($args['core']['label'], 'Produkt');
    $this->assertSame($args['core']['labels'], 'Produkter');
    $this->assertSame($args['core']['type'], 'product');
    $this->assertSame($args['core']['description'], '');
    $this->assertSame($args['core']['quantity'], '0');
    $this->assertSame($args['core']['flush_rewrites'], true);

    $this->assertSame($args['support']['title'], '1');
    $this->assertSame($args['support']['editor'], '1');
    $this->assertSame($args['support']['page-attributes'], '1');

    $this->assertTrue($args['option']['public']              === '1');
    $this->assertTrue($args['option']['publicly_queryable']  === '1');
    $this->assertTrue($args['option']['exclude_from_search'] === '0');
    $this->assertTrue($args['option']['show_ui']             === '1');
    $this->assertTrue($args['option']['show_in_menu']        === '1');
    $this->assertTrue($args['option']['menu_position']       === '');
    $this->assertTrue($args['option']['capability_type']     === 'post');
    $this->assertTrue($args['option']['hierarchical']        === '1');
    $this->assertTrue($args['option']['has_archive']         === '0');
    $this->assertTrue($args['option']['has_archive_slug']    === '');
    $this->assertTrue($args['option']['rewrite']             === '1');
    $this->assertTrue($args['option']['rewrite_slug']        === 'product');
    $this->assertTrue($args['option']['with_front']          === '0');
    $this->assertTrue($args['option']['query_var']           === '1');
    $this->assertTrue($args['option']['can_export']          === '1');
    $this->assertTrue($args['option']['show_in_nav_menus']   === '1');

    $this->assertTrue($args['label']['name']               === 'Produkter');
    $this->assertTrue($args['label']['singular_name']      === 'Produkt');
    $this->assertTrue($args['label']['add_new']            === 'Lägg till produkt');
    $this->assertTrue($args['label']['all_items']          === 'Alla produkter');
    $this->assertTrue($args['label']['add_new_item']       === 'Lägg till ny produkt');
    $this->assertTrue($args['label']['edit_item']          === 'Redigera produkt');
    $this->assertTrue($args['label']['new_item']           === 'Ny produkt');
    $this->assertTrue($args['label']['view_item']          === 'Visa produkt');
    $this->assertTrue($args['label']['search_items']       === 'Sök produkter');
    $this->assertTrue($args['label']['not_found']          === 'Hittade inga produkter');
    $this->assertTrue($args['label']['not_found_in_trash'] === 'Hittade inga produkter i papperskorgen');
    $this->assertTrue($args['label']['parent_item_colon']  === 'Förälder: Produkt');
    $this->assertTrue($args['label']['menu_name']          === 'Produkter');

  }
}
