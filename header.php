<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Remote_Store
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'remotestore' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="top-header">
            <div class="container">
                <div class="top-header-inner">
                    <?php
                    // Display customer service phone number from customizer
                    $phone_number = get_theme_mod('remotestore_customer_service_phone', '1-800-234-5678');
                    if ($phone_number) : ?>
                        <div class="customer-service">
                            <span class="service-text"><?php esc_html_e('24/7 Customer service', 'remotestore'); ?></span>
                            <strong class="service-phone"><?php echo esc_html($phone_number); ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="top-navigation">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'secondary',
                                'menu_id'        => 'secondary-menu',
                                'fallback_cb'    => false,
                                'container'      => false,
                                'depth'          => 1,
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-header">
            <div class="container">
                <div class="main-header-inner">
                    <div class="site-branding">
                        <?php
                        the_custom_logo();
                        if ( is_front_page() && is_home() ) :
                            ?>
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php
                        else :
                            ?>
                            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php
                        endif;
                        ?>
                    </div><!-- .site-branding -->

                    <div class="header-search">
                        <?php remotestore_product_search(); ?>
                    </div>

                    <div class="header-actions">
                        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                            <div class="account-link">
                                <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">
                                    <span class="icon"><i class="fas fa-user"></i></span>
                                    <?php
                                    if ( is_user_logged_in() ) {
                                        esc_html_e( 'My Account', 'remotestore' );
                                    } else {
                                        esc_html_e( 'Log In', 'remotestore' );
                                    }
                                    ?>
                                </a>
                            </div>

                            <div class="cart-link">
                                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                                    <span class="icon"><i class="fas fa-shopping-cart"></i></span>
                                    <span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>

                        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                            <span class="menu-toggle-icon"></span>
                            <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'remotestore' ); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-navigation-wrapper">
            <div class="container">
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                        )
                    );
                    ?>
                </nav><!-- #site-navigation -->
            </div>
        </div>
    </header><!-- #masthead -->

    <div id="content" class="site-content">
        <div class="container">
