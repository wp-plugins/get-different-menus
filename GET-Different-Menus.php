<?php
/*
Plugin Name: GET Different Menus
Plugin URI: http://www.wp-plugin-dev.com
Description: Used to have different Menus by $_GET Parameter
Version: 0.13
Author: wp-plugin-dev.com
Author URI: http://www.wp-plugin-dev.com

I once thought I need different primary menus for different viewers.
In best case those users have a GET paramter which decides which menu has to be shown.

For Example: 
You go into WordPress and add a menu with a name of your choice. I choosed "music".
Now if you want somebody view the music menu you have the parameter http://www.example.com/?view=music.
You can do this with every menu you have.

In case you leave it empty nothing happen at all.


*/

function init_sessions_GET_Different_Menus() {
    if (!session_id()) {
        session_start();
    }




}
add_action('init', 'init_sessions_GET_Different_Menus');



add_action( 'init', 'set_session_to_GET_Different_Menus_parameter');

function set_session_to_GET_Different_Menus_parameter() {

if(!($_SESSION['viewmenu']) && !is_admin()){
$_SESSION['viewmenu']=$_GET['view'];
	}
	else{}


}


add_filter( 'wp_nav_menu_items', 'get_different_custom_menu_item_according_to_get_parameter', 10, 2 );

function get_different_custom_menu_item_according_to_get_parameter ( $items, $args ) {
	$current_id=(int)$GLOBALS['post']->ID;
    $the_nmo = wp_get_nav_menu_object($_SESSION['viewmenu']); 
    
    if ($the_nmo==""){}else{
    
    $menu_id=$the_nmo->term_id;
    $items_2 = wp_get_nav_menu_items($menu_id);
    $items="";
    
   
    if ($args->theme_location == 'primary') {
    
        foreach ($items_2 as $item){

		$link_page_id = (int)($item->object_id);
		
	
	if ($current_id == $link_page_id){$cur=" current-menu-item current_page_item";}else{$cur="";
	} 
  
        $items .= '<li class="menu-item menu-item-type-post_type menu-item-object-page'.$cur.'"><a  href="'.$item->url.'">'.$item->title.'</a></li>';
        
        }
        }
        
    }
    return $items;
}
