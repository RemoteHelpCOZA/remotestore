<?php
/**
 * The template for displaying the front page
 *
 * @package Remote_Store
 */

get_header();
?>

<main id="primary" class="site-main front-page">

    <?php if ( get_theme_mod( 'remotestore_show_hero', true ) ) : ?>
    <section class="hero-section">
        <div class="hero-content">
            <h2><?php echo esc_html( get_theme_mod( 'remotestore_hero_title', __( 'The best home entertainment system is here', 'remotestore' ) ) ); ?></h2>
            <p><?php echo esc_html( get_theme_mod( 'remotestore_hero_subtitle', __( 'Sit diam odio eget rhoncus volutpat est nibh velit posuere egestas.', 'remotestore' ) ) ); ?></p>

            <?php
            $btn_text = get_theme_mod( 'remotestore_hero_button_text', __( 'Shop now', 'remotestore' ) );
            $btn_url = get_theme_mod( 'remotestore_hero_button_url', '#' );

            if ( $btn_text && $btn_url ) : ?>
                <a href="<?php echo esc_url( $btn_url ); ?>" class="button hero-button"><?php echo esc_html( $btn_text ); ?></a>
            <?php endif; ?>
        </div>

        <?php
        $hero_image = get_theme_mod( 'remotestore_hero_image', get_template_directory_uri() . '/assets/images/hero-image.jpg' );
        if ( $hero_image ) : ?>
            <div class="hero-image">
                <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( get_theme_mod( 'remotestore_hero_title', __( 'The best home entertainment system is here', 'remotestore' ) ) ); ?>">
            </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ( get_theme_mod( 'remotestore_show_features', true ) ) : ?>
    <section class="features-section">
        <div class="features-container">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="feature-content">
                    <h3><?php echo esc_html( get_theme_mod( 'remotestore_feature_1_title', __( 'Free shipping', 'remotestore' ) ) ); ?></h3>
                    <p><?php echo esc_html( get_theme_mod( 'remotestore_feature_1_text', __( 'When you spend $80 or more', 'remotestore' ) ) ); ?></p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="feature-content">
                    <h3><?php echo esc_html( get_theme_mod( 'remotestore_feature_2_title', __( 'We are available 24/7', 'remotestore' ) ) ); ?></h3>
                    <p><?php echo esc_html( get_theme_mod( 'remotestore_feature_2_text', __( 'Need help? contact us anytime', 'remotestore' ) ) ); ?></p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-undo"></i>
                </div>
                <div class="feature-content">
                    <h3><?php echo esc_html( get_theme_mod( 'remotestore_feature_3_title', __( 'Satisfied or return', 'remotestore' ) ) ); ?></h3>
                    <p><?php echo esc_html( get_theme_mod( 'remotestore_feature_3_text', __( 'Easy 30-day return policy', 'remotestore' ) ) ); ?></p>
                </div>
            </div>

            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="feature-content">
                    <h3><?php echo esc_html( get_theme_mod( 'remotestore_feature_4_title', __( '100% secure payments', 'remotestore' ) ) ); ?></h3>
                    <p><?php echo esc_html( get_theme_mod( 'remotestore_feature_4_text', __( 'Visa, Mastercard, Stripe, PayPal', 'remotestore' ) ) ); ?></p>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'remotestore_show_product_categories', true ) ) : ?>
    <section class="product-categories-section">
        <div class="categories-container">
            <?php
            // Get selected categories from customizer
            $selected_categories = get_theme_mod( 'remotestore_product_categories', array() );

            // If no categories are selected, get all product categories
            if ( empty( $selected_categories ) ) {
                $product_categories = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'number'     => 8, // Limit to 8 categories
                ) );
            } else {
                $product_categories = get_terms( array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'include'    => $selected_categories,
                ) );
            }

            if ( $product_categories ) {
                foreach ( $product_categories as $category ) {
                    // Get category image
                    $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                    $image = wp_get_attachment_url( $thumbnail_id );

                    // If no image is set, use a placeholder
                    if ( ! $image ) {
                        $image = wc_placeholder_img_src();
                    }

                    // Get product count in this category
                    $product_count = sprintf(
                        /* translators: %d: product count */
                        _n( '%d Product', '%d Products', $category->count, 'remotestore' ),
                        $category->count
                    );

                    ?>
                    <div class="category-item">
                        <a href="<?php echo esc_url( get_term_link( $category ) ); ?>">
                            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $category->name ); ?>">
                            <div class="category-content">
                                <h3><?php echo esc_html( $category->name ); ?></h3>
                                <span class="product-count"><?php echo esc_html( $product_count ); ?></span>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'remotestore_show_banner', true ) ) : ?>
    <section class="banner-section">
        <div class="banner-container">
            <?php
            // Get banner data from customizer
            $banner1_image = get_theme_mod( 'remotestore_banner_1_image', '' );
            $banner1_link = get_theme_mod( 'remotestore_banner_1_link', '#' );
            $banner2_image = get_theme_mod( 'remotestore_banner_2_image', '' );
            $banner2_link = get_theme_mod( 'remotestore_banner_2_link', '#' );

            if ( $banner1_image ) : ?>
                <div class="banner-item banner-1">
                    <a href="<?php echo esc_url( $banner1_link ); ?>">
                        <img src="<?php echo esc_url( $banner1_image ); ?>" alt="">
                    </a>
                </div>
            <?php endif; ?>

            <?php if ( $banner2_image ) : ?>
                <div class="banner-item banner-2">
                    <a href="<?php echo esc_url( $banner2_link ); ?>">
                        <img src="<?php echo esc_url( $banner2_image ); ?>" alt="">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'remotestore_show_deals', true ) ) : ?>
    <section class="deals-section">
        <div class="section-header">
            <h2><?php echo esc_html( get_theme_mod( 'remotestore_deals_title', __( 'Todays best deal', 'remotestore' ) ) ); ?></h2>
            <a href="<?php echo esc_url( get_theme_mod( 'remotestore_deals_more_link', '#' ) ); ?>" class="see-more"><?php esc_html_e( 'See more', 'remotestore' ); ?></a>
        </div>

        <div class="products-container deals-products">
            <?php
            // Get deal products selected in customizer
            $deal_products = get_theme_mod( 'remotestore_deal_products', array() );

            if ( ! empty( $deal_products ) ) {
                $args = array(
                    'post_type'      => 'product',
                    'post__in'       => $deal_products,
                    'posts_per_page' => -1,
                    'orderby'        => 'post__in',
                );
            } else {
                // If no products specifically selected, show on-sale products
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 8,
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array( // Simple products type
                            'key'     => '_sale_price',
                            'value'   => 0,
                            'compare' => '>',
                            'type'    => 'numeric'
                        ),
                        array( // Variable products type
                            'key'     => '_min_variation_sale_price',
                            'value'   => 0,
                            'compare' => '>',
                            'type'    => 'numeric'
                        )
                    ),
                );
            }

            $deal_query = new WP_Query( $args );

            if ( $deal_query->have_posts() ) {
                woocommerce_product_loop_start();

                while ( $deal_query->have_posts() ) {
                    $deal_query->the_post();
                    wc_get_template_part( 'content', 'product' );
                }

                woocommerce_product_loop_end();
                wp_reset_postdata();
            } else {
                echo '<p class="no-products">' . esc_html__( 'No products found', 'remotestore' ) . '</p>';
            }
            ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // Get featured sections from customizer
    $featured_sections = get_theme_mod( 'remotestore_featured_sections', array() );

    if ( class_exists( 'WooCommerce' ) && ! empty( $featured_sections ) ) :
        foreach ( $featured_sections as $index => $section ) :
            if ( isset( $section['category'] ) && ! empty( $section['category'] ) ) :
                $category = get_term( $section['category'], 'product_cat' );
                if ( $category && ! is_wp_error( $category ) ) :
                    $section_title = isset( $section['title'] ) && ! empty( $section['title'] ) ?
                                    $section['title'] : $category->name;
                    $section_image = isset( $section['image'] ) && ! empty( $section['image'] ) ?
                                    $section['image'] : '';
                    $section_link = isset( $section['link'] ) && ! empty( $section['link'] ) ?
                                    $section['link'] : get_term_link( $category );
                    $section_price = isset( $section['price'] ) && ! empty( $section['price'] ) ?
                                    $section['price'] : '';
    ?>
    <section class="featured-section featured-section-<?php echo esc_attr( $index + 1 ); ?>">
        <div class="featured-content">
            <h2><?php echo esc_html( $section_title ); ?></h2>

            <?php if ( $section_price ) : ?>
            <p class="featured-price"><?php
                /* translators: %s: starting price */
                printf( esc_html__( 'Starting at %s', 'remotestore' ), esc_html( $section_price ) );
            ?></p>
            <?php endif; ?>

            <a href="<?php echo esc_url( $section_link ); ?>" class="button"><?php esc_html_e( 'Shop now', 'remotestore' ); ?></a>
        </div>

        <?php if ( $section_image ) : ?>
        <div class="featured-image">
            <img src="<?php echo esc_url( $section_image ); ?>" alt="<?php echo esc_attr( $section_title ); ?>">
        </div>
        <?php endif; ?>
    </section>
    <?php
                endif;
            endif;
        endforeach;
    endif;
    ?>

    <?php if ( class_exists( 'WooCommerce' ) && get_theme_mod( 'remotestore_show_product_sections', true ) ) :
        // Get product sections from customizer
        $product_sections = get_theme_mod( 'remotestore_product_sections', array() );

        if ( ! empty( $product_sections ) ) :
            foreach ( $product_sections as $section ) :
                if ( isset( $section['category'] ) && ! empty( $section['category'] ) ) :
                    $category = get_term( $section['category'], 'product_cat' );
                    if ( $category && ! is_wp_error( $category ) ) :
                        $section_title = isset( $section['title'] ) && ! empty( $section['title'] ) ?
                                        $section['title'] : $category->name;
    ?>
    <section class="product-section">
        <div class="section-header">
            <h2><?php echo esc_html( $section_title ); ?></h2>
            <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="see-more"><?php esc_html_e( 'See more', 'remotestore' ); ?></a>
        </div>

        <div class="products-container">
            <?php
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => 4,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $category->term_id,
                    ),
                ),
            );

            $products_query = new WP_Query( $args );

            if ( $products_query->have_posts() ) {
                woocommerce_product_loop_start();

                while ( $products_query->have_posts() ) {
                    $products_query->the_post();
                    wc_get_template_part( 'content', 'product' );
                }

                woocommerce_product_loop_end();
                wp_reset_postdata();
            } else {
                echo '<p class="no-products">' . esc_html__( 'No products found', 'remotestore' ) . '</p>';
            }
            ?>
        </div>
    </section>
    <?php
                    endif;
                endif;
            endforeach;
        endif;
    endif;
    ?>

</main><!-- #main -->

<?php
get_footer();
