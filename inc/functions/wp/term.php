<?php

/**
 * @return [
 *    @param Array term_tree (empty)
 *    @param Array parent_ids // 1st el - root el
 *    @param Array active_id_path // 1st el - root el
 *    @param Number current_id
 *    @param Array terms
 * ]
 */
function term__get_term_structure_data($term, $parent_id, $taxonomy_name, $args=[]) {
  if (!isset($args['term_tree'])) $args['term_tree'] = [];
  if (!isset($args['parent_ids'])) $args['parent_ids'] = [];
  if (!isset($args['active_id_path'])) $args['active_id_path'] = [ $term->term_id ];
  if (!isset($args['current_id'])) $args['current_id'] = $term->term_id;
  if (!isset($args['terms'])) $args['terms'] = [ $term->term_id => $term ];

  if ($parent_id) {
    array_unshift($args['parent_ids'], $parent_id);
    array_unshift($args['active_id_path'], $parent_id);
    $parent_term = get_term_by( 'id', $parent_id, $taxonomy_name );
    $args['terms'][$parent_term->term_id] = $parent_term;
    return term__get_term_structure_data($parent_term, $parent_term->parent, $taxonomy_name, $args);
  }
  return $args;
}




/**
 * wrong count if use polylang: count all taxonomies in adjacent post_types
 * reliable but work slow!
 */
function term__get_terms_by_post_type( $taxonomy_name, $post_type, $lang=null ) {
  $post_type_posts = get_posts([
    'fields' => 'ids',
    'post_type' => $post_type,
    'posts_per_page' => -1,
    'lang' => $lang,
  ]);
  return wp_get_object_terms( $post_type_posts, $taxonomy_name, ['ids'] );
}



/**
 * @param Array $args - args for get_terms
 *    @param String $args[post_type] - new extra param
 *    returns actual_count
 * @example term__get_terms_by_post_type_2( 'categories', ['post_type' => 'page', ...] ){
 */
function term__get_terms_by_post_type_2( $taxonomies, $args=[] ){
  //Parse $args in case its a query string.
  $args = wp_parse_args($args);

  if( !empty($args['post_type']) ){
      $args['post_type'] = (array) $args['post_type'];
      add_filter( 'terms_clauses','wpse_filter_terms_by_cpt',10,3);

      function wpse_filter_terms_by_cpt( $pieces, $tax, $args){
          global $wpdb;

          // Don't use db count
          $pieces['fields'] .=", COUNT(*) AS 'actual_count' " ;

          //Join extra tables to restrict by post type.
          $pieces['join'] .=" INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id 
                              INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id ";

          // Restrict by post type and Group by term_id for COUNTing.
          $post_types_str = implode(',',$args['post_type']);
          $pieces['where'].= $wpdb->prepare(" AND p.post_type IN(%s) GROUP BY t.term_id", $post_types_str);

          remove_filter( current_filter(), __FUNCTION__ );
          return $pieces;
      }
  } // endif post_type set
  return get_terms($taxonomies, $args);           
}










/**
 * @param Array $args
 *   @param String category_tax_name*
 *   @param String tag_tax_name*
 *   @param Array category_ids*
 *   @param String term_id_alisas = term_id
 *   @param String name_alisas = name
 *   @param String link_alisas = link
 */
function term__tags_of_category_by_category_id($args) {
  global $wpdb;
  $category_ids_str = join(',', $args['category_ids']);
  $term_id_alisas = isset($args['term_id_alisas'])? $args['term_id_alisas'] : 'term_id';
  $name_alisas = isset($args['name_alisas'])? $args['name_alisas'] : 'name';
  $link_alisas = isset($args['link_alisas'])? $args['link_alisas'] : 'link';

  $tags = $wpdb->get_results
  ("
      SELECT DISTINCT terms2.term_id as $term_id_alisas, terms2.name as $name_alisas, null as $link_alisas
      FROM
          {$wpdb->prefix}posts as p1
          LEFT JOIN {$wpdb->prefix}term_relationships as r1 ON p1.ID = r1.object_ID
          LEFT JOIN {$wpdb->prefix}term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
          LEFT JOIN {$wpdb->prefix}terms as terms1 ON t1.term_id = terms1.term_id,

          {$wpdb->prefix}posts as p2
          LEFT JOIN {$wpdb->prefix}term_relationships as r2 ON p2.ID = r2.object_ID
          LEFT JOIN {$wpdb->prefix}term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
          LEFT JOIN {$wpdb->prefix}terms as terms2 ON t2.term_id = terms2.term_id
      WHERE
          t1.taxonomy = '". $args['category_tax_name'] ."' AND p1.post_status = 'publish' AND terms1.term_id IN (". $category_ids_str .") AND
          t2.taxonomy = '". $args['tag_tax_name'] ."' AND p2.post_status = 'publish'
          AND p1.ID = p2.ID
      ORDER by $name_alisas
  ");
  $count = 0;
  foreach ($tags as $tag) {
      $tags[$count]->{$link_alisas} = get_tag_link($tag->{$term_id_alisas});
      $count++;
  }
  return $tags;
}