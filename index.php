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

function jkp_enqueue_script() {
  if ('0' === get_option('jkp_disable_button', '0')) {
    wp_enqueue_script(
      'jkp-addThis',
      '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51f5e4a1711e7cbe',
      array(),
      null,
      false
    );
  }
}
add_action('wp_enqueue_scripts', 'jkp_enqueue_script');
 
function addThis_option_script($num_preferred, $position) {
?>
  <script type="text/javascript">
    addthis.layers({
      'theme' : 'transparent',
      'share' : {
        'position' : 'left',
        'numPreferredServices' : 5
      }   
    });
  </script>
<?php
}
add_action('wp_footer', 'addThis_option_script');

function jkp_add_options_page() {
  add_options_page(
    __('JKP Options'),
    __('JKP Options'),
    'manage_options',
    'jkp_options_page',
    'jkp_render_options_page'
  );
}
add_action('admin_menu', 'jkp_add_options_page');

function jkp_render_options_page() {
  ?>
  <div class="wrap">
    <?php screen_icon(); ?>
    <h2><?php _e('JKP Options'); ?></h2>
    <form action="options.php" method="post">
      <?php settings_fields('jkp_disable_button'); ?>
      <?php do_settings_sections('jkp_options_page'); ?>
      <p class="submit">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes'); ?>">
      </p>
    </form>
  </div>
  <?php
}

function jkp_add_addThis_settings() {
  register_setting(
    'jkp_disable_button',
    'jkp_disable_button',
    'absint'
  );

  add_settings_section(
    'jkp_main_settings',
    __('JKP Controls'),
    'jkp_render_main_settings_section',
    'jkp_options_page'
  );

  add_settings_field(
    'jkp_disable_button_field',
    __('Disable AddThis Buttons'),
    'jkp_render_disable_button_input',
    'jkp_options_page',
    'jkp_main_settings'
  );

  add_settings_field(
    'jkp_num_preferred_field',
    __('How many Share buttons?'),
    'jkp_render_num_preferred_input',
    'jkp_options_page',
    'jkp_main_settings'
  );

  add_settings_field(
    'jkp_position_field',
    __('Pick a Position'),
    'jkp_render_position_input',
    'jkp_options_page',
    'jkp_main_settings'
  );
}
add_action('admin_init', 'jkp_add_addThis_settings');

function jkp_render_main_settings_section() {
  echo '<p>Main settings for the JKP plugin.</p>';
}

function jkp_render_disable_button_input() {
  $current = get_option('jkp_disable_button', 0);
  echo '<input id="jkp-disable-button" name="jkp_disable_button" type="checkbox" value="1" ' . checked( 1, $current, false ) . ' />';
}

function jkp_render_num_preferred_input() {
  // num preferred input field
}

function jkp_render_position_input() {
  // position input field
}