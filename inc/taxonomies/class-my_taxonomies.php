<?php

class MY_TAXONOMIES {
  
  public function register() {
    global $my_cpt;
    if ( empty((array) $my_cpt) ){
      $my_tax = (object) [];
      $my_tax->names = [];
    }
    
    require_once 'class-my_tax_news_category.php';
    $x = new MY_TAXONOMY_NEWS_CATEGORY;
    $x->register();
    $my_cpt->names[] = MY_TAX_NEWS_CATEGORY;
    
    require_once 'class-my_tax_news_tag.php';
    $x = new MY_TAXONOMY_NEWS_TAG;
    $x->register();
    $my_cpt->names[] = MY_TAX_NEWS_TAG;
    
    require_once 'class-my_tax_product_industry_type.php';
    $x = new MY_TAXONOMY_PRODUCT_INDUSTRY_TYPE;
    $x->register();
    $my_cpt->names[] = MY_TAX_PRODUCT_INDUSTRY_TYPE;
    
    require_once 'class-my_tax_product_type.php';
    $x = new MY_TAXONOMY_PRODUCT_TYPE;
    $x->register();
    $my_cpt->names[] = MY_TAX_PRODUCT_TYPE;
  }
}