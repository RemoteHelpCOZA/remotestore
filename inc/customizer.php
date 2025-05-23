<?php
/**
 * Remote Store Theme Customizer
 *
 * @package Remote_Store
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function remotestore_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'remotestore_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'remotestore_customize_partial_blogdescription',
            )
        );
    }

    // Header Options Section
    $wp_customize->add_section(
        'remotestore_header_options',
        array(
            'title'    => __( 'Header Options', 'remotestore' ),
            'priority' => 30,
        )
    );

    // Customer Service Phone
    $wp_customize->add_setting(
        'remotestore_customer_service_phone',
        array(
            'default'           => '1-800-234-5678',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'remotestore_customer_service_phone',
        array(
            'label'    => __( 'Customer Service Phone', 'remotestore' ),
            'section'  => 'remotestore_header_options',
            'type'     => 'text',
            'priority' => 10,
        )
    );

    // Footer Options Section
    $wp_customize->add_section(
        'remotestore_footer_options',
        array(
            'title'    => __( 'Footer Options', 'remotestore' ),
            'priority' => 90,
        )
    );

    // Copyright Text
    $wp_customize->add_setting(
        'remotestore_copyright_text',
        array(
            'default'           => sprintf(
                /* translators: %s: Current year and site name */
                __( '© %s. All Rights Reserved.', 'remotestore' ),
                date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' )
            ),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'remotestore_copyright_text',
        array(
            'label'    => __( 'Copyright Text', 'remotestore' ),
            'section'  => 'remotestore_footer_options',
            'type'     => 'textarea',
            'priority' => 10,
        )
    );

    // Show Payment Icons
    $wp_customize->add_setting(
        'remotestore_show_payment_icons',
        array(
            'default'           => true,
            'sanitize_callback' => 'remotestore_sanitize_checkbox',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'remotestore_show_payment_icons',
        array(
            'label'    => __( 'Show Payment Icons', 'remotestore' ),
            'section'  => 'remotestore_footer_options',
            'type'     => 'checkbox',
            'priority' => 20,
        )
    );

    // Payment Icons Image
    $wp_customize->add_setting(
        'remotestore_payment_icons',
        array(
            'default'           => get_template_directory_uri() . '/assets/images/payment-methods.png',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'remotestore_payment_icons',
            array(
                'label'    => __( 'Payment Icons Image', 'remotestore' ),
                'section'  => 'remotestore_footer_options',
                'settings' => 'remotestore_payment_icons',
                'priority' => 30,
            )
        )
    );

    // Homepage Sections
    if ( class_exists( 'WooCommerce' ) ) {
        $wp_customize->add_panel(
            'remotestore_homepage_panel',
            array(
                'title'    => __( 'Homepage Sections', 'remotestore' ),
                'priority' => 40,
            )
        );

        // Hero Section
        $wp_customize->add_section(
            'remotestore_hero_section',
            array(
                'title'    => __( 'Hero Section', 'remotestore' ),
                'panel'    => 'remotestore_homepage_panel',
                'priority' => 10,
            )
        );

        // Show Hero Section
        $wp_customize->add_setting(
            'remotestore_show_hero',
            array(
                'default'           => true,
                'sanitize_callback' => 'remotestore_sanitize_checkbox',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_show_hero',
            array(
                'label'    => __( 'Show Hero Section', 'remotestore' ),
                'section'  => 'remotestore_hero_section',
                'type'     => 'checkbox',
                'priority' => 10,
            )
        );

        // Hero Title
        $wp_customize->add_setting(
            'remotestore_hero_title',
            array(
                'default'           => __( 'The best home entertainment system is here', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_hero_title',
            array(
                'label'    => __( 'Hero Title', 'remotestore' ),
                'section'  => 'remotestore_hero_section',
                'type'     => 'text',
                'priority' => 20,
            )
        );

        // Hero Subtitle
        $wp_customize->add_setting(
            'remotestore_hero_subtitle',
            array(
                'default'           => __( 'Sit diam odio eget rhoncus volutpat est nibh velit posuere egestas.', 'remotestore' ),
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_hero_subtitle',
            array(
                'label'    => __( 'Hero Subtitle', 'remotestore' ),
                'section'  => 'remotestore_hero_section',
                'type'     => 'textarea',
                'priority' => 30,
            )
        );

        // Hero Button Text
        $wp_customize->add_setting(
            'remotestore_hero_button_text',
            array(
                'default'           => __( 'Shop now', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_hero_button_text',
            array(
                'label'    => __( 'Hero Button Text', 'remotestore' ),
                'section'  => 'remotestore_hero_section',
                'type'     => 'text',
                'priority' => 40,
            )
        );

        // Hero Button URL
        $wp_customize->add_setting(
            'remotestore_hero_button_url',
            array(
                'default'           => '#',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_hero_button_url',
            array(
                'label'    => __( 'Hero Button URL', 'remotestore' ),
                'section'  => 'remotestore_hero_section',
                'type'     => 'url',
                'priority' => 50,
            )
        );

        // Hero Image
        $wp_customize->add_setting(
            'remotestore_hero_image',
            array(
                'default'           => get_template_directory_uri() . '/assets/images/hero-image.jpg',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'remotestore_hero_image',
                array(
                    'label'    => __( 'Hero Image', 'remotestore' ),
                    'section'  => 'remotestore_hero_section',
                    'settings' => 'remotestore_hero_image',
                    'priority' => 60,
                )
            )
        );

        // Features Section
        $wp_customize->add_section(
            'remotestore_features_section',
            array(
                'title'    => __( 'Features Section', 'remotestore' ),
                'panel'    => 'remotestore_homepage_panel',
                'priority' => 20,
            )
        );

        // Show Features Section
        $wp_customize->add_setting(
            'remotestore_show_features',
            array(
                'default'           => true,
                'sanitize_callback' => 'remotestore_sanitize_checkbox',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_show_features',
            array(
                'label'    => __( 'Show Features Section', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'checkbox',
                'priority' => 10,
            )
        );

        // Feature 1 Title
        $wp_customize->add_setting(
            'remotestore_feature_1_title',
            array(
                'default'           => __( 'Free shipping', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_1_title',
            array(
                'label'    => __( 'Feature 1 Title', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 20,
            )
        );

        // Feature 1 Text
        $wp_customize->add_setting(
            'remotestore_feature_1_text',
            array(
                'default'           => __( 'When you spend $80 or more', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_1_text',
            array(
                'label'    => __( 'Feature 1 Text', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 25,
            )
        );

        // Feature 2 Title
        $wp_customize->add_setting(
            'remotestore_feature_2_title',
            array(
                'default'           => __( 'We are available 24/7', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_2_title',
            array(
                'label'    => __( 'Feature 2 Title', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 30,
            )
        );

        // Feature 2 Text
        $wp_customize->add_setting(
            'remotestore_feature_2_text',
            array(
                'default'           => __( 'Need help? contact us anytime', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_2_text',
            array(
                'label'    => __( 'Feature 2 Text', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 35,
            )
        );

        // Feature 3 Title
        $wp_customize->add_setting(
            'remotestore_feature_3_title',
            array(
                'default'           => __( 'Satisfied or return', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_3_title',
            array(
                'label'    => __( 'Feature 3 Title', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 40,
            )
        );

        // Feature 3 Text
        $wp_customize->add_setting(
            'remotestore_feature_3_text',
            array(
                'default'           => __( 'Easy 30-day return policy', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_3_text',
            array(
                'label'    => __( 'Feature 3 Text', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 45,
            )
        );

        // Feature 4 Title
        $wp_customize->add_setting(
            'remotestore_feature_4_title',
            array(
                'default'           => __( '100% secure payments', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_4_title',
            array(
                'label'    => __( 'Feature 4 Title', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 50,
            )
        );

        // Feature 4 Text
        $wp_customize->add_setting(
            'remotestore_feature_4_text',
            array(
                'default'           => __( 'Visa, Mastercard, Stripe, PayPal', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_feature_4_text',
            array(
                'label'    => __( 'Feature 4 Text', 'remotestore' ),
                'section'  => 'remotestore_features_section',
                'type'     => 'text',
                'priority' => 55,
            )
        );

        // Product Categories Section
        $wp_customize->add_section(
            'remotestore_categories_section',
            array(
                'title'    => __( 'Product Categories Section', 'remotestore' ),
                'panel'    => 'remotestore_homepage_panel',
                'priority' => 30,
            )
        );

        // Show Product Categories Section
        $wp_customize->add_setting(
            'remotestore_show_product_categories',
            array(
                'default'           => true,
                'sanitize_callback' => 'remotestore_sanitize_checkbox',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_show_product_categories',
            array(
                'label'    => __( 'Show Product Categories Section', 'remotestore' ),
                'section'  => 'remotestore_categories_section',
                'type'     => 'checkbox',
                'priority' => 10,
            )
        );

        // Product Categories
        $product_categories = remotestore_get_product_categories_for_customizer();

        $wp_customize->add_setting(
            'remotestore_product_categories',
            array(
                'default'           => array(),
                'sanitize_callback' => 'remotestore_sanitize_multiple_checkboxes',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'remotestore_product_categories',
                array(
                    'label'    => __( 'Select Product Categories', 'remotestore' ),
                    'section'  => 'remotestore_categories_section',
                    'type'     => 'select',
                    'multiple' => true,
                    'choices'  => $product_categories,
                    'priority' => 20,
                )
            )
        );

        // Banner Section
        $wp_customize->add_section(
            'remotestore_banner_section',
            array(
                'title'    => __( 'Banner Section', 'remotestore' ),
                'panel'    => 'remotestore_homepage_panel',
                'priority' => 40,
            )
        );

        // Show Banner Section
        $wp_customize->add_setting(
            'remotestore_show_banner',
            array(
                'default'           => true,
                'sanitize_callback' => 'remotestore_sanitize_checkbox',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_show_banner',
            array(
                'label'    => __( 'Show Banner Section', 'remotestore' ),
                'section'  => 'remotestore_banner_section',
                'type'     => 'checkbox',
                'priority' => 10,
            )
        );

        // Banner 1 Image
        $wp_customize->add_setting(
            'remotestore_banner_1_image',
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'remotestore_banner_1_image',
                array(
                    'label'    => __( 'Banner 1 Image', 'remotestore' ),
                    'section'  => 'remotestore_banner_section',
                    'settings' => 'remotestore_banner_1_image',
                    'priority' => 20,
                )
            )
        );

        // Banner 1 Link
        $wp_customize->add_setting(
            'remotestore_banner_1_link',
            array(
                'default'           => '#',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_banner_1_link',
            array(
                'label'    => __( 'Banner 1 Link', 'remotestore' ),
                'section'  => 'remotestore_banner_section',
                'type'     => 'url',
                'priority' => 30,
            )
        );

        // Banner 2 Image
        $wp_customize->add_setting(
            'remotestore_banner_2_image',
            array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'remotestore_banner_2_image',
                array(
                    'label'    => __( 'Banner 2 Image', 'remotestore' ),
                    'section'  => 'remotestore_banner_section',
                    'settings' => 'remotestore_banner_2_image',
                    'priority' => 40,
                )
            )
        );

        // Banner 2 Link
        $wp_customize->add_setting(
            'remotestore_banner_2_link',
            array(
                'default'           => '#',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_banner_2_link',
            array(
                'label'    => __( 'Banner 2 Link', 'remotestore' ),
                'section'  => 'remotestore_banner_section',
                'type'     => 'url',
                'priority' => 50,
            )
        );

        // Deals Section
        $wp_customize->add_section(
            'remotestore_deals_section',
            array(
                'title'    => __( 'Deals Section', 'remotestore' ),
                'panel'    => 'remotestore_homepage_panel',
                'priority' => 50,
            )
        );

        // Show Deals Section
        $wp_customize->add_setting(
            'remotestore_show_deals',
            array(
                'default'           => true,
                'sanitize_callback' => 'remotestore_sanitize_checkbox',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_show_deals',
            array(
                'label'    => __( 'Show Deals Section', 'remotestore' ),
                'section'  => 'remotestore_deals_section',
                'type'     => 'checkbox',
                'priority' => 10,
            )
        );

        // Deals Title
        $wp_customize->add_setting(
            'remotestore_deals_title',
            array(
                'default'           => __( 'Todays best deal', 'remotestore' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_deals_title',
            array(
                'label'    => __( 'Deals Section Title', 'remotestore' ),
                'section'  => 'remotestore_deals_section',
                'type'     => 'text',
                'priority' => 20,
            )
        );

        // Deals More Link
        $wp_customize->add_setting(
            'remotestore_deals_more_link',
            array(
                'default'           => '#',
                'sanitize_callback' => 'esc_url_raw',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_deals_more_link',
            array(
                'label'    => __( 'Deals "See more" Link', 'remotestore' ),
                'section'  => 'remotestore_deals_section',
                'type'     => 'url',
                'priority' => 30,
            )
        );

        // Deal Products
        $products = remotestore_get_products_for_customizer();

        $wp_customize->add_setting(
            'remotestore_deal_products',
            array(
                'default'           => array(),
                'sanitize_callback' => 'remotestore_sanitize_multiple_checkboxes',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'remotestore_deal_products',
                array(
                    'label'    => __( 'Select Deal Products', 'remotestore' ),
                    'section'  => 'remotestore_deals_section',
                    'type'     => 'select',
                    'multiple' => true,
                    'choices'  => $products,
                    'priority' => 40,
                )
            )
        );

        // Featured Sections
        $wp_customize->add_section(
            'remotestore_featured_sections',
            array(
                'title'    => __( 'Featured Category Sections', 'remotestore' ),
                'panel'    => 'remotestore_homepage_panel',
                'priority' => 60,
            )
        );

        // Featured Sections
        $wp_customize->add_setting(
            'remotestore_featured_sections',
            array(
                'default'           => array(),
                'sanitize_callback' => 'remotestore_sanitize_featured_sections',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            new Remotestore_Featured_Sections_Control(
                $wp_customize,
                'remotestore_featured_sections',
                array(
                    'label'       => __( 'Featured Category Sections', 'remotestore' ),
                    'section'     => 'remotestore_featured_sections',
                    'settings'    => 'remotestore_featured_sections',
                    'categories'  => $product_categories,
                    'priority'    => 10,
                )
            )
        );

        // Product Sections
        $wp_customize->add_section(
            'remotestore_product_sections',
            array(
                'title'    => __( 'Product Sections', 'remotestore' ),
                'panel'    => 'remotestore_homepage_panel',
                'priority' => 70,
            )
        );

        // Show Product Sections
        $wp_customize->add_setting(
            'remotestore_show_product_sections',
            array(
                'default'           => true,
                'sanitize_callback' => 'remotestore_sanitize_checkbox',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            'remotestore_show_product_sections',
            array(
                'label'    => __( 'Show Product Sections', 'remotestore' ),
                'section'  => 'remotestore_product_sections',
                'type'     => 'checkbox',
                'priority' => 10,
            )
        );

        // Product Sections
        $wp_customize->add_setting(
            'remotestore_product_sections',
            array(
                'default'           => array(),
                'sanitize_callback' => 'remotestore_sanitize_product_sections',
                'transport'         => 'refresh',
            )
        );

        $wp_customize->add_control(
            new Remotestore_Product_Sections_Control(
                $wp_customize,
                'remotestore_product_sections',
                array(
                    'label'       => __( 'Product Sections', 'remotestore' ),
                    'section'     => 'remotestore_product_sections',
                    'settings'    => 'remotestore_product_sections',
                    'categories'  => $product_categories,
                    'priority'    => 20,
                )
            )
        );
    }
}
add_action( 'customize_register', 'remotestore_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function remotestore_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function remotestore_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function remotestore_customize_preview_js() {
    wp_enqueue_script( 'remotestore-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), REMOTESTORE_VERSION, true );
}
add_action( 'customize_preview_init', 'remotestore_customize_preview_js' );

/**
 * Sanitize checkbox.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function remotestore_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitize multiple checkboxes.
 *
 * @param array $values Values to sanitize.
 * @return array Sanitized values.
 */
function remotestore_sanitize_multiple_checkboxes( $values ) {
    $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

    return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}

/**
 * Sanitize featured sections.
 *
 * @param array $sections Sections to sanitize.
 * @return array Sanitized sections.
 */
function remotestore_sanitize_featured_sections( $sections ) {
    if ( !is_array( $sections ) ) {
        return array();
    }

    $sanitized_sections = array();

    foreach ( $sections as $section ) {
        $sanitized_section = array();

        if ( isset( $section['category'] ) ) {
            $sanitized_section['category'] = absint( $section['category'] );
        }

        if ( isset( $section['title'] ) ) {
            $sanitized_section['title'] = sanitize_text_field( $section['title'] );
        }

        if ( isset( $section['image'] ) ) {
            $sanitized_section['image'] = esc_url_raw( $section['image'] );
        }

        if ( isset( $section['link'] ) ) {
            $sanitized_section['link'] = esc_url_raw( $section['link'] );
        }

        if ( isset( $section['price'] ) ) {
            $sanitized_section['price'] = sanitize_text_field( $section['price'] );
        }

        $sanitized_sections[] = $sanitized_section;
    }

    return $sanitized_sections;
}

/**
 * Sanitize product sections.
 *
 * @param array $sections Sections to sanitize.
 * @return array Sanitized sections.
 */
function remotestore_sanitize_product_sections( $sections ) {
    if ( !is_array( $sections ) ) {
        return array();
    }

    $sanitized_sections = array();

    foreach ( $sections as $section ) {
        $sanitized_section = array();

        if ( isset( $section['category'] ) ) {
            $sanitized_section['category'] = absint( $section['category'] );
        }

        if ( isset( $section['title'] ) ) {
            $sanitized_section['title'] = sanitize_text_field( $section['title'] );
        }

        $sanitized_sections[] = $sanitized_section;
    }

    return $sanitized_sections;
}

/**
 * Get product categories for customizer.
 *
 * @return array Array of categories.
 */
function remotestore_get_product_categories_for_customizer() {
    $categories = array();

    if ( class_exists( 'WooCommerce' ) ) {
        $product_categories = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
        ) );

        if ( !empty( $product_categories ) && !is_wp_error( $product_categories ) ) {
            foreach ( $product_categories as $category ) {
                $categories[$category->term_id] = $category->name;
            }
        }
    }

    return $categories;
}

/**
 * Get products for customizer.
 *
 * @return array Array of products.
 */
function remotestore_get_products_for_customizer() {
    $products = array();

    if ( class_exists( 'WooCommerce' ) ) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $products[get_the_ID()] = get_the_title();
            }

            wp_reset_postdata();
        }
    }

    return $products;
}

/**
 * Enqueue customizer control scripts.
 */
function remotestore_customizer_control_scripts() {
    wp_enqueue_script( 'remotestore-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array( 'jquery', 'customize-controls' ), REMOTESTORE_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'remotestore_customizer_control_scripts' );

/**
 * Custom control for featured sections.
 */
if ( class_exists( 'WP_Customize_Control' ) && !class_exists( 'Remotestore_Featured_Sections_Control' ) ) {
    class Remotestore_Featured_Sections_Control extends WP_Customize_Control {
        public $type = 'featured_sections';
        public $categories = array();

        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <div class="featured-sections-container">
                <div class="featured-sections-list">
                    <?php
                    $sections = $this->value();

                    if ( !empty( $sections ) && is_array( $sections ) ) {
                        foreach ( $sections as $index => $section ) {
                            $this->render_section( $index, $section );
                        }
                    }
                    ?>
                </div>
                <button type="button" class="button add-section"><?php esc_html_e( 'Add Section', 'remotestore' ); ?></button>
            </div>
            <?php
        }

        public function render_section( $index, $section ) {
            ?>
            <div class="featured-section">
                <h4><?php esc_html_e( 'Featured Section', 'remotestore' ); ?> <?php echo esc_html( $index + 1 ); ?></h4>

                <label>
                    <?php esc_html_e( 'Category', 'remotestore' ); ?>
                    <select class="category-select">
                        <option value=""><?php esc_html_e( 'Select Category', 'remotestore' ); ?></option>
                        <?php foreach ( $this->categories as $id => $name ) : ?>
                            <option value="<?php echo esc_attr( $id ); ?>" <?php selected( isset( $section['category'] ) ? $section['category'] : '', $id ); ?>><?php echo esc_html( $name ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <?php esc_html_e( 'Title (optional)', 'remotestore' ); ?>
                    <input type="text" class="title-input" value="<?php echo esc_attr( isset( $section['title'] ) ? $section['title'] : '' ); ?>">
                </label>

                <label>
                    <?php esc_html_e( 'Image URL', 'remotestore' ); ?>
                    <input type="url" class="image-input" value="<?php echo esc_url( isset( $section['image'] ) ? $section['image'] : '' ); ?>">
                </label>

                <label>
                    <?php esc_html_e( 'Link URL (optional)', 'remotestore' ); ?>
                    <input type="url" class="link-input" value="<?php echo esc_url( isset( $section['link'] ) ? $section['link'] : '' ); ?>">
                </label>

                <label>
                    <?php esc_html_e( 'Starting Price (optional)', 'remotestore' ); ?>
                    <input type="text" class="price-input" value="<?php echo esc_attr( isset( $section['price'] ) ? $section['price'] : '' ); ?>">
                </label>

                <button type="button" class="button remove-section"><?php esc_html_e( 'Remove', 'remotestore' ); ?></button>
            </div>
            <?php
        }
    }
}

/**
 * Custom control for product sections.
 */
if ( class_exists( 'WP_Customize_Control' ) && !class_exists( 'Remotestore_Product_Sections_Control' ) ) {
    class Remotestore_Product_Sections_Control extends WP_Customize_Control {
        public $type = 'product_sections';
        public $categories = array();

        public function render_content() {
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <div class="product-sections-container">
                <div class="product-sections-list">
                    <?php
                    $sections = $this->value();

                    if ( !empty( $sections ) && is_array( $sections ) ) {
                        foreach ( $sections as $index => $section ) {
                            $this->render_section( $index, $section );
                        }
                    }
                    ?>
                </div>
                <button type="button" class="button add-section"><?php esc_html_e( 'Add Section', 'remotestore' ); ?></button>
            </div>
            <?php
        }

        public function render_section( $index, $section ) {
            ?>
            <div class="product-section">
                <h4><?php esc_html_e( 'Product Section', 'remotestore' ); ?> <?php echo esc_html( $index + 1 ); ?></h4>

                <label>
                    <?php esc_html_e( 'Category', 'remotestore' ); ?>
                    <select class="category-select">
                        <option value=""><?php esc_html_e( 'Select Category', 'remotestore' ); ?></option>
                        <?php foreach ( $this->categories as $id => $name ) : ?>
                            <option value="<?php echo esc_attr( $id ); ?>" <?php selected( isset( $section['category'] ) ? $section['category'] : '', $id ); ?>><?php echo esc_html( $name ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <?php esc_html_e( 'Title (optional)', 'remotestore' ); ?>
                    <input type="text" class="title-input" value="<?php echo esc_attr( isset( $section['title'] ) ? $section['title'] : '' ); ?>">
                </label>

                <button type="button" class="button remove-section"><?php esc_html_e( 'Remove', 'remotestore' ); ?></button>
            </div>
            <?php
        }
    }
}
