<?php
/*
Plugin Name: JKP Custom
Plugin URI: http://rabble.com
Version: 1.0
Description: Custom pluging to control AddThis buttons
Author: Jace Poirier-Pinto
Author URI: http://jacewdim393f.wordpress.com
License: GNU General Public License v2 or later
*/

function jkp_admin() {  
  include('jkp_template_admin.php');  
} 

function jkp_admin_actions() {  
  add_options_page("JKP Options", "JKP Options", 1, "JKP Options", "jkp_admin");  
}  
add_action('admin_menu', 'jkp_admin_actions');