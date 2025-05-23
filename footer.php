<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Remote_Store
 */

?>
        </div><!-- .container -->
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <div class="footer-widget-area">
                    <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                        <div class="footer-widget footer-widget-1">
                            <?php dynamic_sidebar( 'footer-1' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                        <div class="footer-widget footer-widget-2">
                            <?php dynamic_sidebar( 'footer-2' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                        <div class="footer-widget footer-widget-3">
                            <?php dynamic_sidebar( 'footer-3' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                        <div class="footer-widget footer-widget-4">
                            <?php dynamic_sidebar( 'footer-4' ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="copyright">
                    <?php
                    $copyright_text = get_theme_mod('remotestore_copyright_text', sprintf(
                        /* translators: %s: Current year and site name */
                        esc_html__( '© %s. All Rights Reserved.', 'remotestore' ),
                        date_i18n( 'Y' ) . ' ' . get_bloginfo( 'name' )
                    ));
                    echo wp_kses_post( $copyright_text );
                    ?>
                </div>

                <?php if ( get_theme_mod( 'remotestore_show_payment_icons', true ) ) : ?>
                    <div class="payment-methods">
                        <?php
                        // Payment method icons from customizer
                        $payment_icons_url = get_theme_mod( 'remotestore_payment_icons', get_template_directory_uri() . '/assets/images/payment-methods.png' );
                        if ( $payment_icons_url ) :
                        ?>
                            <img src="<?php echo esc_url( $payment_icons_url ); ?>" alt="<?php esc_attr_e( 'Payment Methods', 'remotestore' ); ?>" />
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer-menu',
                        'menu_id'        => 'footer-menu',
                        'container'      => 'nav',
                        'container_class' => 'footer-menu',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    )
                );
                ?>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
