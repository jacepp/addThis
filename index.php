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
 
function addThis_option_script() {
  if ('0' === get_option('jkp_disable_button', '0')) {
?>
  <script type="text/javascript">
    addthis.layers({
      'theme' : 'transparent',
      'share' : {
        'position' : <?php echo "'". get_option('jkp_position', 'left') ."'";  ?>,
        'numPreferredServices' : <?php echo get_option('jkp_num_preferred', 4) ?>
      }   
    });
  </script>
<?php
  }
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
      <?php settings_fields('jkp_option_group'); ?>
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
    'jkp_option_group',
    'jkp_disable_button',
    'absint'
  );

  register_setting(
    'jkp_option_group',
    'jkp_num_preferred',
    'absint'
  );

  register_setting(
    'jkp_option_group',
    'jkp_position'
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
  echo '<input id="jkp-disable-button" name="jkp_disable_button" type="checkbox" value="1"'. checked(1, $current, false) .'/>';
}

function jkp_render_num_preferred_input() {
  $current = get_option('jkp_num_preferred', 4);
  echo '<label><input type="radio" name="jkp_num_preferred" value="1"'. checked(1, $current, false) .'/> 1 </label>';
  echo '<label><input type="radio" name="jkp_num_preferred" value="2"'. checked(2, $current, false) .'/> 2 </label>';
  echo '<label><input type="radio" name="jkp_num_preferred" value="3"'. checked(3, $current, false) .'/> 3 </label>';
  echo '<label><input type="radio" name="jkp_num_preferred" value="4"'. checked(4, $current, false) .'/> 4 </label>';
  echo '<label><input type="radio" name="jkp_num_preferred" value="5"'. checked(5, $current, false) .'/> 5 </label>';
  echo '<label><input type="radio" name="jkp_num_preferred" value="6"'. checked(6, $current, false) .'/> 6 </label>';
}

function jkp_render_position_input() {
  $current = get_option('jkp_position', 'left');
  echo '<select name="jkp_position">';
  echo '<option value="left"'. selected('left', $current, false) .'>Left</option>';
  echo '<option value="right"'. selected('right', $current, false) .'>Right</option>';
  echo '</select>';
}