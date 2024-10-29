<?php
function adminimal_bar_settings() {
  // Check if user is allowed to manage options
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }
  
  // Output the settings page HTML
  ?>
  <div class="wrap">
    <h1>AdMinimal Bar Settings</h1>
    <form method="post" action="options.php">
      <?php
      settings_fields('adminimal-bar-settings');
      do_settings_sections('adminimal-bar-settings');
      submit_button('Save Settings');
      ?>
    </form>
  </div>
  <?php
}

function adminimal_bar_settings_init() {
  register_setting(
    'adminimal-bar-settings',
    'adminimal_bar_enabled',
    array(
      'type' => 'boolean',
      'description' => 'Enable or disable AdMinimal Bar',
      'sanitize_callback' => 'sanitize_text_field',
      'default' => true
    )
  );
  
  register_setting(
    'adminimal-bar-settings', 
    'adminimal_bar_orientation',
    array(
      'type' => 'string',
      'description' => 'AdMinimal Bar Orientation',
      'sanitize_callback' => 'sanitize_text_field',
      'default' => 'default'
    )
  );
  
  register_setting(
    'adminimal-bar-settings',
    'adminimal_bar_minimized_transparent',
    array(
      'type' => 'boolean',
      'description' => 'Minimized Background Transparent',
      'sanitize_callback' => 'sanitize_text_field',
      'default' => false
    )
  );
  
  register_setting(
    'adminimal-bar-settings',
    'adminimal_bar_minimized_logo_color',
    array(
      'type' => 'string',
      'description' => 'Minimized WP Logo Color',
      'sanitize_callback' => 'sanitize_text_field',
      'default' => '#000000'
    )
  );
  
  add_settings_section(
    'adminimal-bar-section',
    'AdMinimal Bar Settings',
    'adminimal_bar_section_description',
    'adminimal-bar-settings'
  );
  
  add_settings_field(
    'adminimal-bar-enabled-field',
    'Enable AdMinimal Bar',
    'adminimal_bar_enabled_field',
    'adminimal-bar-settings',
    'adminimal-bar-section'
  );
  
  add_settings_field(
    'adminimal-bar-orientation-field',
    'AdMinimal Bar Orientation',
    'adminimal_bar_orientation_field',
    'adminimal-bar-settings',
    'adminimal-bar-section'
  );
  
  add_settings_field(
    'adminimal-bar-minimized-transparent-field',
    'Minimized Background Transparent',
    'adminimal_bar_minimized_transparent_field',
    'adminimal-bar-settings',
    'adminimal-bar-section'
  );
  
  add_settings_field(
    'adminimal-bar-minimized-logo-color-field',
    'Minimized WP Logo Color',
    'adminimal_bar_minimized_logo_color_field',
    'adminimal-bar-settings',
    'adminimal-bar-section'
  );
}

function adminimal_bar_section_description() {
  echo '<p>Enable/disable or customize the AdMinimal Bar frontend styles.</p>';
}

function adminimal_bar_enabled_field() {
  $option_value = get_option('adminimal_bar_enabled');
  ?>
  <input type="checkbox" name="adminimal_bar_enabled" value="1" <?php checked( $option_value, true ); ?> />
  <?php
}

function adminimal_bar_orientation_field() {
  $option_value = get_option('adminimal_bar_orientation');
  ?>
  <select name="adminimal_bar_orientation">
    <option value="horizontal" <?php selected( $option_value, 'horizontal' ); ?>>Horizontal</option>
    <option value="vertical" <?php selected( $option_value, 'vertical' ); ?>>Vertical</option>
  </select>
  <?php
}

function adminimal_bar_minimized_transparent_field() {
  $option_value = get_option('adminimal_bar_minimized_transparent');
  ?>
  <input type="checkbox" name="adminimal_bar_minimized_transparent" value="1" <?php checked( $option_value, true ); ?> />
  <?php
}
function adminimal_bar_minimized_logo_color_field() {
  $option_value = get_option('adminimal_bar_minimized_logo_color');
  $transparent_option_value = get_option('adminimal_bar_minimized_transparent');
  ?>
  <input type="color" name="adminimal_bar_minimized_logo_color" value="<?php echo esc_attr( $option_value ); ?>" />
  <?php if ($transparent_option_value) : ?>
    <p class="description">Only applies when background is transparent.</p>
  <?php endif; ?>
  <?php
}

add_action('admin_init', 'adminimal_bar_settings_init');
