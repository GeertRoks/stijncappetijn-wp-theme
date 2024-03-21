<?php
/*
 * Plugin Name:       Stijn Cappetijn Website Configuration
 * Description:       Site configurator for the custom nuxt3 website of Stijn Cappetijn that uses the wordpress REST API.
 */

function isImageOrVideoFile($fileName) {
    // Regular expression to match image file extensions
    $imageExtensions = '/(\.jpg|\.jpeg|\.png|\.gif|\.bmp|\.svg\+xml)$/i';
    // Regular expression to match video file extensions
    $videoExtensions = '/(\.mp4|\.webm|\.ogg|\.flv|\.avi|\.mov|\.wmv|\.mkv)$/i';

    // Check if the file name matches any of the image or video extensions
    if (preg_match($imageExtensions, $fileName)) {
        return 'image';
    } elseif (preg_match($videoExtensions, $fileName)) {
        return 'video';
    } else {
        return 'unknown';
    }
}

function previewVideoImage($class) {
    $html = '<div class="' . $class . ' image-preview-container" style="display: none;">';

    if (isImageOrVideoFile(get_option($class)) == 'video') {
        $html .= '<video class="' . $class . ' video-preview" preload="true" autoplay loop muted style="width: 20rem; aspect-ratio: 16/9; object-fit: cover;" src="' . get_option($class) . '">';
    } else {
        $html .= '<video class="' . $class . ' video-preview" preload="true" autoplay loop muted style="width: 20rem; aspect-ratio: 16/9; object-fit: cover; display: none;" src="' . get_option($class) . '">';
    }

    $html .= '</video>';

    if (isImageOrVideoFile(get_option($class)) == 'image') {
        $html .= '<img class="' . $class . ' image-preview" src="' . get_option($class) . '" alt="Preview" style="width: 15rem; aspect-ratio: 1/1" />';
    } else {
        $html .= '<img class="' . $class . ' image-preview" src="' . get_option($class) . '" alt="Preview" style="width: 15rem; aspect-ratio: 1/1; display: none;" />';
    }

    $html .= '<a href="#" class="' . $class . ' remove-image">Remove image/video</a>';
    $html .= '</div>';
    $html .= '<button class="button ' . $class . ' select-image-button">Select Picture</button>';
    $html .= '<input type="hidden" class="' . $class . ' image-url" name="' . $class . '" value="' . get_option($class) . '" />';
    return $html;
}


function stijncappetijn_adminpage_configmenu() {
  add_menu_page(
    'Site Configuration',
    'Site Configuration',
    'manage_options',
    'site-configuration',
    'stijncappetijn_config_menu',
    'dashicons-art',
    4
  );
}
add_action('admin_menu','stijncappetijn_adminpage_configmenu');

function stijncappetijn_config_menu() {
?>
  <div class="wrap">
    <h2>Site configuration</h2>
      <form method="post" action="options.php">
        <?php settings_fields('site_configuration_options'); ?>
        <?php do_settings_sections('site_configuration_options'); ?>
          <section>
            <h3>Landing page</h3>
            <p style="margin-bottom:0.25rem;"><strong>Background video or image</strong></p>
            <?php echo previewVideoImage('landing_background') ?>

            <p style="margin-bottom:0.25rem;"><strong>Title</strong></p>
            <input type="text" name="landing_title" style="width:40ch;" value="<?php echo get_option('landing_title'); ?>"/>
            <p style="margin-bottom:0.25rem;"><strong>Subtitle</strong></p>
            <input type="text" name="landing_subtitle" style="width:40ch;" value="<?php echo get_option('landing_subtitle'); ?>"/>
          </section>
          <hr>
          <section>
            <h3>About</h3>

            <p style="margin-bottom:0.25rem;"><strong>Bio title</strong></p>
            <input type="text" name="about_biotitle" style="width:40ch;" value="<?php echo get_option('about_biotitle'); ?>"/>

            <p style="margin-bottom:0.25rem;"><strong>Bio</strong></p>
            <textarea name="about_bio" rows="5" cols="75"><?php echo get_option('about_bio'); ?></textarea>

            <p style="margin-bottom:0.25rem;"><strong>Picture</strong></p>
            <?php echo previewVideoImage('about_picture') ?>

          </section>
          <hr>
          <section>
            <h3>Footer</h3>
            <p><strong>Socials</strong></p>
          </section>
        <?php submit_button(); ?>
      </form>
  </div>
<?php
}

function register_custom_settings() {
    register_setting('site_configuration_options', 'landing_background');
    register_setting('site_configuration_options', 'landing_title');
    register_setting('site_configuration_options', 'landing_subtitle');
    register_setting('site_configuration_options', 'about_biotitle');
    register_setting('site_configuration_options', 'about_bio');
    register_setting('site_configuration_options', 'about_picture');
}
add_action('admin_init', 'register_custom_settings');

function custom_rest_api_endpoint() {
    register_rest_route('plugin_stijncappetijn_config/v1', '/config/', array(
        'methods' => 'GET',
        'callback' => 'get_config_options',
    ));
}
add_action('rest_api_init', 'custom_rest_api_endpoint');

function get_config_options() {
    $landing = get_landing_option();
    $about = get_about_option();
    #$footer = get_footer_option();
    return new WP_REST_Response(array(
      'landing' => $landing,
      'about' => $about,
    ), 200);
}
function get_landing_option() {
    $background = get_option('landing_background');
    $title = get_option('landing_title');
    $subtitle = get_option('landing_subtitle');
    return array(
      'background' => $background,
      'title' => $title,
      'subtitle' => $subtitle,
    );
}
function get_about_option() {
    $biotitle = get_option('about_biotitle');
    $bio = get_option('about_bio');
    $picture = get_option('about_picture');
    return array(
      'biotitle' => $biotitle,
      'bio' => $bio,
      'picture' => $picture,
    );
}
function get_footer_option() {
    //$value = get_option($option_name);
    //return new WP_REST_Response($value, 200);
}

function stijncappetijn_admin_scripts() {
    wp_enqueue_media();
    wp_enqueue_script('admin-js', get_template_directory_uri() . '/assets/admin.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'stijncappetijn_admin_scripts');


?>
