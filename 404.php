<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Remote_Store
 */

get_header();
?>

    <main id="primary" class="site-main">

        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'remotestore' ); ?></h1>
            </header><!-- .page-header -->

            <div class="page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'remotestore' ); ?></p>

                <?php
                get_search_form();

                if ( class_exists( 'WooCommerce' ) ) :
                    ?>
                    <div class="error-404-products">
                        <h2><?php esc_html_e( 'Featured Products', 'remotestore' ); ?></h2>
                        <?php
                        $args = array(
                            'post_type'      => 'product',
                            'posts_per_page' => 4,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'product_visibility',
                                    'field'    => 'name',
                                    'terms'    => 'featured',
                                ),
                            ),
                        );

                        $featured_query = new WP_Query( $args );

                        if ( $featured_query->have_posts() ) {
                            woocommerce_product_loop_start();

                            while ( $featured_query->have_posts() ) {
                                $featured_query->the_post();
                                wc_get_template_part( 'content', 'product' );
                            }

                            woocommerce_product_loop_end();
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                    <?php
                endif;
                ?>

                <div class="widget-area">
                    <?php
                    the_widget( 'WP_Widget_Recent_Posts' );
                    ?>

                    <div class="widget widget_categories">
                        <h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'remotestore' ); ?></h2>
                        <ul>
                            <?php
                            wp_list_categories(
                                array(
                                    'orderby'    => 'count',
                                    'order'      => 'DESC',
                                    'show_count' => 1,
                                    'title_li'   => '',
                                    'number'     => 10,
                                )
                            );
                            ?>
                        </ul>
                    </div><!-- .widget -->

                    <?php
                    /* translators: %1$s: smiley */
                    $remotestore_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'remotestore' ), convert_smilies( ':)' ) ) . '</p>';
                    the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$remotestore_archive_content" );

                    the_widget( 'WP_Widget_Tag_Cloud' );
                    ?>
                </div><!-- .widget-area -->

            </div><!-- .page-content -->
        </section><!-- .error-404 -->

    </main><!-- #main -->

<?php
get_footer();
