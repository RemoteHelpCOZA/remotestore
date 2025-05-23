<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Remote_Store
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function remotestore_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    // Add a class if WooCommerce is active
    if ( class_exists( 'WooCommerce' ) ) {
        $classes[] = 'woocommerce-active';
    }

    return $classes;
}
add_filter( 'body_class', 'remotestore_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function remotestore_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'remotestore_pingback_header' );

/**
 * Add a back to top button to the footer.
 */
function remotestore_back_to_top() {
    echo '<a href="#" class="back-to-top" aria-hidden="true"><i class="fas fa-chevron-up"></i></a>';
}
add_action( 'wp_footer', 'remotestore_back_to_top' );

/**
 * Get SVG icon.
 *
 * @param string $icon Icon name.
 * @return string SVG markup.
 */
function remotestore_get_svg( $icon ) {
    switch ( $icon ) {
        case 'cart':
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path></svg>';
        case 'search':
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>';
        case 'user':
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>';
        case 'shipping':
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48v320c0 26.5 21.5 48 48 48h16c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"></path></svg>';
        case 'support':
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M192 208c0-17.67-14.33-32-32-32h-16c-35.35 0-64 28.65-64 64v48c0 35.35 28.65 64 64 64h16c17.67 0 32-14.33 32-32V208zm176 144c35.35 0 64-28.65 64-64v-48c0-35.35-28.65-64-64-64h-16c-17.67 0-32 14.33-32 32v112c0 17.67 14.33 32 32 32h16zM256 0C113.18 0 4.58 118.83 0 256v16c0 8.84 7.16 16 16 16h16c8.84 0 16-7.16 16-16v-16c0-114.69 93.31-208 208-208s208 93.31 208 208h-.12c.08 2.43.12 165.72.12 165.72 0 23.35-18.93 42.28-42.28 42.28H320c0-26.51-21.49-48-48-48h-32c-26.51 0-48 21.49-48 48s21.49 48 48 48h181.72c49.86 0 90.28-40.42 90.28-90.28V256C507.42 118.83 398.82 0 256 0z"></path></svg>';
        case 'return':
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M53.9 53.9C20.3 87.4 0 134.3 0 184v48c0 26.5 21.5 48 48 48h80v64c0 26.5 21.5 48 48 48h48c26.5 0 48-21.5 48-48v-64h80c26.5 0 48-21.5 48-48v-48c0-49.7-20.3-96.6-53.9-130.1C312.4 20.3 265.5 0 216 0h-32C124.3 0 77.4 20.3 53.9 53.9zM376 224H136v-32c0-22.1 17.9-40 40-40h160c22.1 0 40 17.9 40 40v32zm0 32v32c0 22.1-17.9 40-40 40H176c-22.1 0-40-17.9-40-40v-32h240z"></path></svg>';
        case 'payment':
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM48 64h480c8.8 0 16 7.2 16 16v48H32V80c0-8.8 7.2-16 16-16zm480 384H48c-8.8 0-16-7.2-16-16V224h512v208c0 8.8-7.2 16-16 16zm-336-84v8c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v8c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z"></path></svg>';
        default:
            return '';
    }
}

/**
 * Wrapper for product search - FIXED to prevent function redeclaration
 * This function is a wrapper around WooCommerce's get_product_search_form
 */
function remotestore_product_search() {
    if (class_exists('WooCommerce')) {
        get_product_search_form();
    } else {
        get_search_form();
    }
}

/**
 * Add custom image sizes.
 */
function remotestore_add_image_sizes() {
    add_image_size( 'remotestore-category-thumb', 300, 200, true );
    add_image_size( 'remotestore-featured-section', 500, 400, true );
    add_image_size( 'remotestore-banner', 570, 270, true );
}
add_action( 'after_setup_theme', 'remotestore_add_image_sizes' );

/**
 * Register the required plugins for this theme.
 */
function remotestore_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => true,
        ),
        array(
            'name'      => 'Elementor',
            'slug'      => 'elementor',
            'required'  => false,
        ),
        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),
        array(
            'name'      => 'YITH WooCommerce Wishlist',
            'slug'      => 'yith-woocommerce-wishlist',
            'required'  => false,
        ),
        array(
            'name'      => 'YITH WooCommerce Compare',
            'slug'      => 'yith-woocommerce-compare',
            'required'  => false,
        ),
    );

    $config = array(
        'id'           => 'remotestore',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    if ( function_exists( 'tgmpa' ) ) {
        tgmpa( $plugins, $config );
    }
}
add_action( 'tgmpa_register', 'remotestore_register_required_plugins' );

/**
 * Get featured products for the homepage.
 *
 * @param int $limit Number of products to return.
 * @return WP_Query
 */
function remotestore_get_featured_products( $limit = 4 ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return null;
    }

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => 'featured',
            ),
        ),
    );

    return new WP_Query( $args );
}
