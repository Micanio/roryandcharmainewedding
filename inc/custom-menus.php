<?php


// Removing Menu Items
function remove_menu_items() {
  global $menu;
  $restricted = array(
  	//__('Posts'),
  	__('Links'),
  	__('Comments'),
  	//__('Media'),
  	//__('Plugins'),
  	//__('Tools'),
  	//__('Settings'),
  	//__('Users')
  );
  end ($menu);
  while (prev($menu)){
    $value = explode(' ',$menu[key($menu)][0]);
    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
      unset($menu[key($menu)]);}
    }
  }

add_action('admin_menu', 'remove_menu_items');
// Removing sub menus
function remove_submenus() {
  global $submenu;
  unset($submenu['index.php'][10]); // Removes 'Updates'.
  unset($submenu['themes.php'][5]); // Removes 'Themes'.
  //unset($submenu['themes.php'][6]); // Removes 'Customise'.
  //unset($submenu['options-general.php'][15]); // Removes 'Writing'.
  //unset($submenu['options-general.php'][25]); // Removes 'Discussion'.
  unset($submenu['edit.php'][16]); // Removes 'Tags'.
  //unset($submenu['plugins.php'][10]); // Removes Add New plugins
  //unset($submenu['plugins.php'][15]); // Removes Plugins Editor
}
add_action('admin_menu', 'remove_submenus');
// Remove Appearance editor menus
//function remove_editor_menu() {
  //remove_action('admin_menu', '_add_themes_utility_last', 101);
//}
//add_action('_admin_menu', 'remove_editor_menu', 1);



register_nav_menus( array(
  /*'site_map' => 'Site map',*/
  'main_menu' => 'Main Menu',
  'footer_first' => 'Footer Menu 1',
  'footer_second' => 'Footer Menu 2',
  'footer_third' => 'Footer Menu 3'
) );
