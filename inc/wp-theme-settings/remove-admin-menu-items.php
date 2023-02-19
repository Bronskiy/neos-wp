<?php
add_action( 'admin_init', function() {
  /* debug menu items. For removing use 2 element in array */
  // echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';

  /* Removes menu items */
  // remove_menu_page( 'edit-comments.php' );          //Comments
  // remove_menu_page( 'themes.php' );                 //Appearance
  // remove_menu_page( 'plugins.php' );                //Plugins
  // remove_menu_page( 'users.php' );                  //Users
  // remove_menu_page( 'edit.php' );                   //Posts

  /* possible removings */
  // remove_menu_page( 'index.php' );                  //Dashboard
  // remove_menu_page( 'upload.php' );                 //Media
  // remove_menu_page( 'edit.php?post_type=page' );    //Pages
  // remove_menu_page( 'tools.php' );                  //Tools
  // remove_menu_page( 'options-general.php' );        //Settings 
});

