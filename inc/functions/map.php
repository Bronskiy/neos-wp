<?php
/**
  * @param Array $elements
  *  Array (
  *     [num] => ['id' => id, parent_id => id, ...],
  *     [0] => ['id' => 46, parent_id => 0, ...],
  *     [1] => ['id' => 68, parent_id => 46, ...],
  *     [2] => ['id' => 5, parent_id => 22, ...],
  *     [3] => ['id' => 25, parent_id => 12, ...],
  *     ...
  *  )
  * @param Array $args
  *   @param Function $args[callback] ($element) must retern $element!
  * 
  * @return Array (
  *     [69] => Array (
  *             [id] => 69
  *             [parent_id] => 0
  *             [parent_ids] => [...]
  *             ...
  *             [children] => Array (
  *                     [74] => Array (
  *                             [id] => 74
  *                             [parent_id] => 69
  *                             [parent_ids] => [...]
  *                             ...
  *                         )
  *                     [75] ...
  *                )
  *         )
  *     [70] ...
  */
function map__buildTree_with_props(array $elements, $args=[]) {
  $parentId = isset($args['parentId'])? $args['parentId'] : 0;
  $parentIdPropName = isset($args['parent_id_prop_name'])? $args['parent_id_prop_name'] : 'parent_id';
  $idPropName = $args['id_prop_name']? $args['id_prop_name'] : 'id';
  $parent_ids = isset($args['parent_ids'])? $args['parent_ids'] : [];
  $lvl = isset($args['lvl'])? $args['lvl'] : 1;
  $args['callback'] = isset($args['callback'])? $args['callback'] : false;
  $branch = [];

  if ($lvl > 1) {
    $parent_ids[] = $parentId;
  }

  foreach ($elements as $element) {
    if ($element[ $parentIdPropName ] == $parentId) {
      $element['parent_ids'] = $parent_ids;
      
      $children = map__buildTree_with_props($elements, [
        'parentId' => $element[ $idPropName ],
        'parent_id_prop_name' => $parentIdPropName,
        'id_prop_name' => $idPropName,
        'parent_ids' => $parent_ids,
        'parent_ids' => $parent_ids,
        'callback' => $args['callback'],
        'lvl' => $lvl + 1,
      ]);
      $element['children'] = $children? $children : [];
      if ($args['callback']) $element = $args['callback']($element);
      $branch[$element[ $idPropName ]] = $element;
    }
  }

  return $branch;
}


function map__collapse_tree_to_1_lvl_array( $map_tree ) {
  $arr = [];

  if ( isset($map_tree) && count($map_tree) ) {
    foreach ($map_tree as $index => $v) {
      $arr[$index] = $v;
      unset($arr[$index]['children']);
      $arr = array_merge($arr, map__collapse_tree_to_1_lvl_array($v['children']));
    }
  }
  return $arr;
}




/**
  * @param Array $elements
  *  Array (
  *     [num] => ['id' => id, parent_id => id, ...],
  *     [0] => ['id' => 46, parent_id => 0, ...],
  *     [1] => ['id' => 68, parent_id => 46, ...],
  *     [2] => ['id' => 5, parent_id => 22, ...],
  *     [3] => ['id' => 25, parent_id => 12, ...],
  *     ...
  *  )
  * @param Number $parentId
  * 
  * @return Array
  *    (
  *        [69] => Array
  *            (
  *                [74] => n
  *                [79] => n
  *                [73] => Array
  *                    (
  *                        [75] => Array
  *                            (
  *                                [76] => n
  *                                [77] => Array
  *                                    (
  *                                        [80] => Array
  *                                            (
  *                                                [81] => n
  *                                            )
  *    
  *                                        [82] => n
  *                                    )
  *    
  *                            )
  *    
  *                    )
  *    
  *                [72] => n
  *            )
  *    
  *        [70] => Array
  *            (
  *                [78] => n
  *            )
  *    
  *    )
  */
function map__buildTree(array $elements, $parentId=0) {
  $branch = [];

  foreach ($elements as $element) {
    if ($element['parent_id'] == $parentId) {
      $children = map__buildTree($elements, $element['id']);
      if ($children) {
        $element[$element['id']] = $children;
      }

      $branch[$element['id']] = isset($element[$element['id']])? $element[$element['id']] : 'n';
    }
  }

  return $branch;
}