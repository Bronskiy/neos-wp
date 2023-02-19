<?php

function wp_menu__get_id_by_menu_slug( $slug ) {
  return get_nav_menu_locations()[ $slug ];
}




function wp_menu__get_menu_items_by_menu_slug( $slug ) {
  return wp_get_nav_menu_items( wp_menu__get_id_by_menu_slug( $slug ) );
}




function wp_menu__get( $menu_slug_or_id ) {
  $menu_map = []; 
  $menu_items = [];
  if (gettype($menu_slug_or_id) === 'integer') {
    $menu_items = wp_get_nav_menu_items( $menu_slug_or_id );
  }
  else {
    $menu_items = wp_menu__get_menu_items_by_menu_slug( $menu_slug_or_id );
  }
  $menu_items = array__set_item_prop_val_as_item_key( 'ID', $menu_items );

	$someMenuItems = [];
	foreach ($menu_items as $v) {
		$someMenuItems[$v->ID] = [
      'id' => $v->ID,
      'parent_id' => $v->menu_item_parent,
    ];
  }
  
  $menuMap = [0 => map__buildTree($someMenuItems)];
  $menu_map = wp_menu__get_structured_menu_array($menu_items, $menuMap);
  
  return (object) [
    'items' => $menu_items,
    'map' => $menu_map
  ];
}




function wp_menu__get_structured_menu_array( $menu_items, $map ) {
  // $GLOBALS["____MENU_ACTIVE_ID_PATH____"] = [];
  $GLOBALS["____MENU_ACTIVE_IDS____"] = [];
  $menu_map = wp_menu__get_structured_menu_array__recursive( $menu_items, $map, '', null )->menu;

  $menu_map = array__recursive_handler([
    'map' => $menu_map,
    'callback' => function($el) {
      if ( in_array($el['ID'], $GLOBALS['____MENU_ACTIVE_IDS____']) ) {
        $el['active'] = 1;
      }
      return $el;
    }
  ]);

  return $menu_map;
}




/**
 * @param Array $menu_items
 *      Array (
 *         [ID] => [ID => 62, ...],
 *         [87] => [ID => 87, ...],
 *         ...
 *      )
 * @param Array $map - result of build_parent_child_map()
 */
function wp_menu__get_structured_menu_array__recursive( $menu_items, $map, $idPath='', $parent_id=null ) {
  $active = 0;
  $newMenu = [];
  foreach ($map[0] as $id => $lvl_1) {
    $WP_Post = $menu_items[$id];
    $__id__ = $WP_Post->ID;

    $newMenu[$id]['ID'] = $WP_Post->ID;
    $newMenu[$id]['parent_id'] = $parent_id;
    $newMenu[$id]['id_path'] = $idPath? "$idPath-$__id__" : "$__id__";
    $newMenu[$id]['title'] = $WP_Post->title;
    $newMenu[$id]['attr_title'] = $WP_Post->attr_title;
    $newMenu[$id]['object_id'] = $WP_Post->ID == $WP_Post->object_id? 'custom_link' : $WP_Post->object_id;

    if (_current_POST_ID_ == $WP_Post->object_id) {
      $active = 1;
      $newMenu[$id]['active'] = 1;
    }
    else {
      $newMenu[$id]['active'] = 0;
    }
    
    if (_current_POST_ID_ == $WP_Post->object_id) {
      $ids = explode('-', $newMenu[$id]['id_path']);
      // $GLOBALS["____MENU_ACTIVE_ID_PATH____"][] = $newMenu[$id]['id_path'];
      $GLOBALS["____MENU_ACTIVE_IDS____"] = array_merge($GLOBALS["____MENU_ACTIVE_IDS____"], $ids);
    }
    
    $newMenu[$id]['url'] = $WP_Post->url;
    $newMenu[$id]['children'] = is_string($lvl_1)? [] : $lvl_1;

    if ( count($newMenu[$id]['children']) ) {
      $map2 = array(0 => $newMenu[$id]['children']);
      $_ = wp_menu__get_structured_menu_array__recursive( $menu_items, $map2, $newMenu[$id]['id_path'], $__id__ );
      $newMenu[$id]['children'] = $_->menu;

      if ($_->active) {
        $newMenu[$id]['active'] = 1;
      }
    }
  }

  return (object) [
    'active' => $active, // is neede for recursive
    'menu' => array_values($newMenu),
  ];
}