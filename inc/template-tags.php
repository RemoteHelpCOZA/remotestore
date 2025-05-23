<?php
/**
 * Custom template tags for this theme
 *
 * @package Remote_Store
 */

if ( ! function_exists( 'remotestore_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function remotestore_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'remotestore' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;

if ( ! function_exists( 'remotestore_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function remotestore_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'remotestore' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }
endif;

if ( ! function_exists( 'remotestore_entry_footer' ) ) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function remotestore_entry_footer() {
        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'remotestore' ) );
            if ( $categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'remotestore' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'remotestore' ) );
            if ( $tags_list ) {
                /* translators: 1: list of tags. */
                printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'remotestore' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'remotestore' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'remotestore' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                wp_kses_post( get_the_title() )
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if ( ! function_exists( 'remotestore_post_thumbnail' ) ) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function remotestore_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail(
                    'post-thumbnail',
                    array(
                        'alt' => the_title_attribute(
                            array(
                                'echo' => false,
                            )
                        ),
                    )
                );
                ?>
            </a>

            <?php
        endif; // End is_singular().
    }
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
    /**
     * Shim for sites older than 5.2.
     *
     * @link https://core.trac.wordpress.org/ticket/12563
     */
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
endif;

if ( ! function_exists( 'remotestore_breadcrumb' ) ) :
    /**
     * Display custom breadcrumbs.
     */
    function remotestore_breadcrumb() {
        if ( function_exists( 'woocommerce_breadcrumb' ) && class_exists( 'WooCommerce' ) ) {
            woocommerce_breadcrumb();
        } else {
            if ( ! is_home() ) {
                echo '<nav class="breadcrumb">';
                echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'remotestore' ) . '</a>';

                if ( is_category() || is_single() ) {
                    echo ' <i class="fas fa-chevron-right"></i> ';
                    the_category( ' <i class="fas fa-chevron-right"></i> ' );

                    if ( is_single() ) {
                        echo ' <i class="fas fa-chevron-right"></i> ';
                        the_title();
                    }
                } elseif ( is_page() ) {
                    echo ' <i class="fas fa-chevron-right"></i> ';
                    the_title();
                }

                echo '</nav>';
            }
        }
    }
endif;

if ( ! function_exists( 'remotestore_pagination' ) ) :
    /**
     * Display pagination.
     */
    function remotestore_pagination() {
        if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
            woocommerce_pagination();
        } else {
            the_posts_pagination(
                array(
                    'mid_size'  => 2,
                    'prev_text' => '<i class="fas fa-chevron-left"></i>',
                    'next_text' => '<i class="fas fa-chevron-right"></i>',
                )
            );
        }
    }
endif;

if ( ! function_exists( 'remotestore_display_mini_cart' ) ) :
    /**
     * Display mini cart.
     */
    function remotestore_display_mini_cart() {
        if ( class_exists( 'WooCommerce' ) ) {
            ?>
            <div class="mini-cart-wrapper">
                <div class="mini-cart-toggle">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                </div>
                <div class="mini-cart-content">
                    <div class="widget_shopping_cart_content">
                        <?php woocommerce_mini_cart(); ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }
endif;

if ( ! function_exists( 'remotestore_product_search' ) ) :
    /**
     * Display product search form.
     */
    function remotestore_product_search() {
        if ( class_exists( 'WooCommerce' ) ) {
            ?>
            <div class="product-search-wrapper">
                <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label class="screen-reader-text" for="woocommerce-product-search-field"><?php esc_html_e( 'Search for:', 'remotestore' ); ?></label>
                    <input type="search" id="woocommerce-product-search-field" class="search-field" placeholder="<?php esc_attr_e( 'Search products&hellip;', 'remotestore' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit"><i class="fas fa-search"></i></button>
                    <input type="hidden" name="post_type" value="product" />
                </form>
            </div>
            <?php
        } else {
            get_search_form();
        }
    }
endif;

if ( ! function_exists( 'remotestore_woocommerce_header_cart' ) ) :
    /**
     * Display Header Cart.
     */
    function remotestore_woocommerce_header_cart() {
        if ( class_exists( 'WooCommerce' ) ) {
            ?>
            <div class="header-cart">
                <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'remotestore' ); ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
                </a>
            </div>
            <?php
        }
    }
endif;

if ( ! function_exists( 'remotestore_mobile_search' ) ) :
    /**
     * Display mobile search button.
     */
    function remotestore_mobile_search() {
        ?>
        <button class="mobile-search-toggle">
            <i class="fas fa-search"></i>
            <span class="screen-reader-text"><?php esc_html_e( 'Search', 'remotestore' ); ?></span>
        </button>
        <div class="mobile-search-form">
            <?php remotestore_product_search(); ?>
        </div>
        <?php
    }
endif;

if ( ! function_exists( 'remotestore_header_account' ) ) :
    /**
     * Display account link.
     */
    function remotestore_header_account() {
        if ( class_exists( 'WooCommerce' ) ) {
            ?>
            <div class="header-account">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( 'dashboard' ) ); ?>">
                    <i class="fas fa-user"></i>
                    <span class="screen-reader-text"><?php esc_html_e( 'My Account', 'remotestore' ); ?></span>
                </a>
            </div>
            <?php
        }
    }
endif;

if ( ! function_exists( 'remotestore_header_wishlist' ) ) :
    /**
     * Display wishlist link.
     */
    function remotestore_header_wishlist() {
        if ( class_exists( 'WooCommerce' ) && function_exists( 'YITH_WCWL' ) ) {
            ?>
            <div class="header-wishlist">
                <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>">
                    <i class="fas fa-heart"></i>
                    <span class="screen-reader-text"><?php esc_html_e( 'Wishlist', 'remotestore' ); ?></span>
                    <?php if ( function_exists( 'yith_wcwl_count_all_products' ) ) : ?>
                        <span class="count"><?php echo esc_html( yith_wcwl_count_all_products() ); ?></span>
                    <?php endif; ?>
                </a>
            </div>
            <?php
        }
    }
endif;

if ( ! function_exists( 'remotestore_header_compare' ) ) :
    /**
     * Display compare link.
     */
    function remotestore_header_compare() {
        if ( class_exists( 'WooCommerce' ) && function_exists( 'yith_woocompare_constructor' ) ) {
            global $yith_woocompare;
            ?>
            <div class="header-compare">
                <a href="<?php echo esc_url( $yith_woocompare->obj->view_table_url() ); ?>">
                    <i class="fas fa-exchange-alt"></i>
                    <span class="screen-reader-text"><?php esc_html_e( 'Compare', 'remotestore' ); ?></span>
                </a>
            </div>
            <?php
        }
    }
endif;
