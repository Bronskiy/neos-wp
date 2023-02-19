<?php

/**
 * @param Array $fields - result of get_fields (ACF)
 * @param String|Array $jsVarName - the name of window variable or path to target object @example ['_$_', 'wp', 'contacts']
 */
function acf_constructor__contacts__parse( $fields, $jsVarName="" ) {
  if (!$fields) $fields = [];
  $fullResArr = array();
  $htmlResArr = array();
  foreach ($fields as $key => $v) {
    // Email
    if ($key === 'emails') {
      $fullResArr['emails'] = [];
      $htmlResArr['emails'] = [];
      foreach ($v as $dataArr) {
        $href = "mailto:" . $dataArr['email'];
        $a = "<a href=\"$href\">". $dataArr['prefix'] . $dataArr['email'] . $dataArr['postfix'] . "</a>";
        if ($jsVarName) $fullResArr['emails'][] = array_merge( $dataArr, ['href' => $href] );
        $htmlResArr['emails'][] = $a;
      }
    }

    // Telephone
    else if ($key === 'telephones') {
      $fullResArr['telephones'] = [];
      $htmlResArr['telephones'] = [];
      foreach ($v as $dataArr) {
        $tel = ($dataArr['telephone'][0] == '+'? '+' : '') . preg_replace('/\D+/', '', $dataArr['telephone']);
        $href = "tel:" . $tel;
        $a = "<a href=\"$href\">". $dataArr['prefix'] . $dataArr['telephone'] . $dataArr['postfix'] . "</a>";
        if ($jsVarName) $fullResArr['telephones'][] = array_merge( $dataArr, ['href' => $href] );
        $htmlResArr['telephones'][] = $a;
      }
    }

    // Сontact Сolumns
    else if ($key === 'contact_columns') {
      $fullResArr['contact_columns'] = [];
      $htmlResArr['contact_columns'] = [];
      foreach ($v as $n => $v2) {
        $col = $v2['column'];
        $fullResArr['contact_columns'][$n] = [];
        $htmlResArr['contact_columns'][$n] = [];
        foreach ($col as $col_v) {
          // string
          if ($col_v['acf_fc_layout'] === 'string') {
            $htmlResArr['contact_columns'][$n][] = $col_v['string'];
            if ($jsVarName) {
              $fullResArr['contact_columns'][$n][] = $col_v;
            }
          }
          // textarea
          if ($col_v['acf_fc_layout'] === 'textarea') {
            $htmlResArr['contact_columns'][$n][] = $col_v['textarea'];
            if ($jsVarName) {
              $fullResArr['contact_columns'][$n][] = $col_v;
            }
          }
          // link_string
          if ( $col_v['acf_fc_layout'] === 'link_string' && $col_v['link'] ) {
            $target = $col_v['link']['target'] ? $col_v['link']['target'] : '_self';
            $htmlResArr['contact_columns'][$n][] = "<a href=\"". $col_v['link']['url'] ."\" target=\"$target\" ". $col_v['link_attributes'] .">". $col_v['prefix'] . $col_v['link']['title'] . $col_v['postfix'] . "</a>";
            if ($jsVarName) {
              $fullResArr['contact_columns'][$n][] = $col_v;
            }
          }
          // map
          if ( $col_v['acf_fc_layout'] === 'map' ) {
            $title = $col_v['address']? $col_v['address'] : $col_v['coordinates'];
            $q = $col_v['coordinates']? $col_v['coordinates'] : $col_v['address'];
            $href = "https://maps.google.com/?q=". urlencode( strip_tags($q) );
            $htmlResArr['contact_columns'][$n][] = "<a href=\"$href\" target=\"_blank\">". $col_v['prefix'] . $title . $col_v['postfix'] . "</a>";
            if ($jsVarName) {
              $fullResArr['contact_columns'][$n][] = array_merge($col_v, ['href' => $href]);
            }
          }
        }
      }
    }

    // Social Network
    else if ($key === 'social_networks') {
      $fullResArr['social_networks'] = [];
      $htmlResArr['social_networks'] = [];
      foreach ($v as $dataArr) {
        $href = '';
        if ($dataArr['link']) {
          $href = $dataArr['link']['url'];
          $a = "<a href='$href' {$dataArr['link_attributes']}>". $dataArr['prefix'] .
            ( $dataArr['link']['title']? $dataArr['link']['title'] : $dataArr['link']['url'] )
          . $dataArr['postfix'] . "</a>";
        } else $a = '';
        $htmlResArr['social_networks'][] = $a;
        if ($jsVarName) $fullResArr['social_networks'][] = array_merge( $dataArr, ['href' => $href] );
      }
    }

    else {
      $fullResArr[$key] = $v;
      $htmlResArr[$key] = $v;
    }
  }

  if ($jsVarName) acf_constructor__u__print_js_object_in_html_from_php_array( $jsVarName, $fullResArr );

  return [
    'full' => $fullResArr,
    'html' => $htmlResArr,
  ];
}