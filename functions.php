<?php
/**
 * Remote Store functions and definitions
 *
 * @package Remote_Store
 */

if ( ! defined( 'REMOTESTORE_VERSION' ) ) {
    // Replace the version number as needed
    define( 'REMOTESTORE_VERSION', '1.0.1' );
}

/**
 * Global constants - defines essential paths and parameters
 * Avoiding any translation-loading functionality
 */
if ( ! defined( 'REMOTESTORE_DIR' ) ) {
    define( 'REMOTESTORE_DIR', get_template_directory() );
}
if ( ! defined( 'REMOTESTORE_URI' ) ) {
    define( 'REMOTESTORE_URI', get_template_directory_uri() );
}

/**
 * The core theme setup function - delay load until after WordPress fully initializes
 * This prevents early translation loading errors
 */
function remotestore_setup() {
    /**
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    // Important: Only load text domain at init hook or later
    add_action('init', function() {
        load_theme_textdomain('remotestore', get_template_directory() . '/languages');
    }, 5);

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Register nav menus - but without using esc_html__ which could trigger early translation loading
    register_nav_menus(
        array(
            'primary' => 'Primary Menu',
            'secondary' => 'Secondary Menu',
            'footer-menu' => 'Footer Menu',
        )
    );

    // Switch default core markup to output valid HTML5.
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'remotestore_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
// Ensure this happens after WordPress is fully loaded
add_action('after_setup_theme', 'remotestore_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function remotestore_content_width() {
    $GLOBALS['content_width'] = apply_filters('remotestore_content_width', 1200);
}
add_action('after_setup_theme', 'remotestore_content_width', 0);

/**
 * Register widget areas - using plain text for widget titles to avoid translation loading
 */
function remotestore_widgets_init() {
    // Register sidebar without using translation functions that might trigger early loads
    register_sidebar(
        array(
            'name'          => 'Sidebar',
            'id'            => 'sidebar-1',
            'description'   => 'Add widgets here.',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => 'Footer 1',
            'id'            => 'footer-1',
            'description'   => 'Add footer widgets here.',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => 'Footer 2',
            'id'            => 'footer-2',
            'description'   => 'Add footer widgets here.',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => 'Footer 3',
            'id'            => 'footer-3',
            'description'   => 'Add footer widgets here.',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => 'Footer 4',
            'id'            => 'footer-4',
            'description'   => 'Add footer widgets here.',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
// Using widgets_init hook which runs after init
add_action('widgets_init', 'remotestore_widgets_init');

/**
 * Enqueue scripts and styles.
 * Delay loading until WordPress is fully initialized
 */
function remotestore_scripts() {
    // Google Fonts
    wp_enqueue_style('remotestore-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap', array(), REMOTESTORE_VERSION);

    // Theme stylesheet
    wp_enqueue_style('remotestore-style', get_stylesheet_uri(), array(), REMOTESTORE_VERSION);
    wp_style_add_data('remotestore-style', 'rtl', 'replace');

    // Main CSS
    wp_enqueue_style('remotestore-main', get_template_directory_uri() . '/assets/css/main.css', array(), REMOTESTORE_VERSION);

    // Responsive CSS
    wp_enqueue_style('remotestore-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), REMOTESTORE_VERSION);

    // WooCommerce custom styles
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('remotestore-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), REMOTESTORE_VERSION);
    }

    // Font Awesome (moved from separate function to here)
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4');

    // Theme JS
    wp_enqueue_script('remotestore-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), REMOTESTORE_VERSION, true);
    wp_enqueue_script('remotestore-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), REMOTESTORE_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
// Using a priority of 50 ensures this runs well after WordPress core is loaded
add_action('wp_enqueue_scripts', 'remotestore_scripts', 50);

/**
 * Include required files at the appropriate time
 * Using closures to prevent early execution
 */
function remotestore_load_includes() {
    // Define files to include - using a later hook and inside a function
    // to prevent them from being loaded too early
    add_action('init', function() {
        // WooCommerce specific functions
        $woocommerce_file = get_template_directory() . '/inc/woocommerce.php';
        if (file_exists($woocommerce_file) && class_exists('WooCommerce')) {
            require_once $woocommerce_file;
        }

        // Template functions and tags - loaded after init
        $template_functions_file = get_template_directory() . '/inc/template-functions.php';
        if (file_exists($template_functions_file)) {
            require_once $template_functions_file;
        }

        $template_tags_file = get_template_directory() . '/inc/template-tags.php';
        if (file_exists($template_tags_file)) {
            require_once $template_tags_file;
        }
    }, 15);

    // Customizer should be loaded later
    add_action('customize_register', function() {
        $customizer_file = get_template_directory() . '/inc/customizer.php';
        if (file_exists($customizer_file)) {
            require_once $customizer_file;
        }
    }, 5);
}
add_action('after_setup_theme', 'remotestore_load_includes', 20);
