<?php
/**
 * WooCommerce Compatibility File
 *
 * @package Remote_Store
 */

/**
 * WooCommerce setup function.
 *
 * @return void
 */
function remotestore_woocommerce_setup() {
    // Add theme support for WooCommerce features
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
// Using a normal priority - this function doesn't use translations
add_action('after_setup_theme', 'remotestore_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 * Move all styles to main wp_enqueue_scripts hook
 */
function remotestore_woocommerce_scripts() {
    // Quantity buttons script
    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    wp_enqueue_script('remotestore-quantity-buttons', get_template_directory_uri() . '/assets/js/quantity-buttons' . $suffix . '.js', array('jquery'), defined('REMOTESTORE_VERSION') ? REMOTESTORE_VERSION : '1.0.1', true);
}
// Using wp_enqueue_scripts with high priority
add_action('wp_enqueue_scripts', 'remotestore_woocommerce_scripts', 100);

/**
 * Disable the default WooCommerce stylesheet.
 *
 * @return void
 */
function remotestore_dequeue_styles() {
    // Dequeue the default WooCommerce styles
    wp_dequeue_style('wc-blocks-style');
}
// Using a late hook with high priority
add_action('wp_enqueue_scripts', 'remotestore_dequeue_styles', 200);

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function remotestore_related_products_args($args) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'remotestore_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Add custom WooCommerce wrapper.
 */
function remotestore_woocommerce_wrapper_before() {
    ?>
    <main id="primary" class="site-main woocommerce-content">
    <?php
}
add_action('woocommerce_before_main_content', 'remotestore_woocommerce_wrapper_before');

function remotestore_woocommerce_wrapper_after() {
    ?>
    </main><!-- #main -->
    <?php
}
add_action('woocommerce_after_main_content', 'remotestore_woocommerce_wrapper_after');

/**
 * Change number of products per row to 4.
 */
function remotestore_loop_columns() {
    return 4;
}
add_filter('loop_shop_columns', 'remotestore_loop_columns');

/**
 * Change number of products displayed per page.
 */
function remotestore_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'remotestore_products_per_page');

/**
 * Add plus/minus buttons to the quantity field.
 * This is moved to footer to ensure it loads after all other scripts
 */
function remotestore_quantity_buttons() {
    ?>
    <script type="text/javascript">
        (function($) {
            $(document).on('click', '.quantity .plus, .quantity .minus', function() {
                var $qty = $(this).closest('.quantity').find('.qty'),
                    currentVal = parseFloat($qty.val()),
                    max = parseFloat($qty.attr('max')),
                    min = parseFloat($qty.attr('min')),
                    step = $qty.attr('step');

                if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                if (max === '' || max === 'NaN') max = '';
                if (min === '' || min === 'NaN') min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

                if ($(this).is('.plus')) {
                    if (max && (max == currentVal || currentVal > max)) {
                        $qty.val(max);
                    } else {
                        $qty.val(currentVal + parseFloat(step));
                    }
                } else {
                    if (min && (min == currentVal || currentVal < min)) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        $qty.val(currentVal - parseFloat(step));
                    }
                }

                $qty.trigger('change');
            });
        })(jQuery);
    </script>
    <?php
}
add_action('wp_footer', 'remotestore_quantity_buttons');

/**
 * Ensure cart contents update when products are added to the cart via AJAX.
 */
function remotestore_header_add_to_cart_fragment($fragments) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
    <?php
    $fragments['span.cart-count'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'remotestore_header_add_to_cart_fragment');

/**
 * Add a custom "New" badge for recent products - avoiding translation functions that trigger early loading
 */
function remotestore_new_badge() {
    global $product;

    // Get the current product ID
    $product_id = $product->get_id();

    // Get the product creation date
    $product_date = strtotime($product->get_date_created());

    // Set a time period for "new" products (30 days)
    $new_days = 30;
    $new_period = 60 * 60 * 24 * $new_days;

    // Check if the product is new
    if ((time() - $product_date) < $new_period) {
        // Using a hard-coded string instead of translation function to avoid early loading
        echo '<span class="new-badge">New</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'remotestore_new_badge', 9);

/**
 * Modify the sale badge text
 */
function remotestore_sale_badge($html, $post, $product) {
    if ($product->is_on_sale()) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();

        if ($regular_price && $sale_price) {
            // Calculate the percentage discount
            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

            // Return the new sale badge with percentage - avoid translation function
            return '<span class="onsale">-' . esc_html($percentage) . '%</span>';
        }
    }

    return $html;
}
add_filter('woocommerce_sale_flash', 'remotestore_sale_badge', 10, 3);

/**
 * Add custom fields to product categories - avoiding translation functions
 */
function remotestore_add_category_fields() {
    ?>
    <div class="form-field">
        <label for="category_featured">Feature this category on homepage</label>
        <input type="checkbox" name="category_featured" id="category_featured" value="1" />
        <p class="description">Check this box to feature this category in the homepage categories section.</p>
    </div>
    <div class="form-field">
        <label for="category_display_order">Display Order</label>
        <input type="number" name="category_display_order" id="category_display_order" value="0" />
        <p class="description">Set the display order for this category in the homepage categories section.</p>
    </div>
    <?php
}
add_action('product_cat_add_form_fields', 'remotestore_add_category_fields');

/**
 * Edit custom fields for product categories
 */
function remotestore_edit_category_fields($term) {
    $featured = get_term_meta($term->term_id, 'category_featured', true);
    $display_order = get_term_meta($term->term_id, 'category_display_order', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category_featured">Feature this category on homepage</label></th>
        <td>
            <input type="checkbox" name="category_featured" id="category_featured" value="1" <?php checked($featured, 1); ?> />
            <p class="description">Check this box to feature this category in the homepage categories section.</p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category_display_order">Display Order</label></th>
        <td>
            <input type="number" name="category_display_order" id="category_display_order" value="<?php echo esc_attr($display_order ? $display_order : 0); ?>" />
            <p class="description">Set the display order for this category in the homepage categories section.</p>
        </td>
    </tr>
    <?php
}
add_action('product_cat_edit_form_fields', 'remotestore_edit_category_fields');

/**
 * Save custom fields for product categories
 */
function remotestore_save_category_fields($term_id) {
    if (isset($_POST['category_featured'])) {
        update_term_meta($term_id, 'category_featured', 1);
    } else {
        update_term_meta($term_id, 'category_featured', 0);
    }

    if (isset($_POST['category_display_order'])) {
        update_term_meta($term_id, 'category_display_order', intval($_POST['category_display_order']));
    }
}
add_action('created_product_cat', 'remotestore_save_category_fields');
add_action('edited_product_cat', 'remotestore_save_category_fields');

/**
 * Function to get featured product categories for homepage
 */
function remotestore_get_featured_categories($limit = 8) {
    $args = array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'meta_query' => array(
            array(
                'key'     => 'category_featured',
                'value'   => 1,
                'compare' => '='
            )
        ),
        'meta_key'     => 'category_display_order',
        'orderby'      => 'meta_value_num',
        'order'        => 'ASC',
        'number'       => $limit
    );

    return get_terms($args);
}

/**
 * Function to get products on sale for deals section
 */
function remotestore_get_sale_products($limit = 8) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
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

    return new WP_Query($args);
}

/**
 * Function to get recently added products
 */
function remotestore_get_new_products($limit = 8) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    return new WP_Query($args);
}

/**
 * Function to get best selling products
 */
function remotestore_get_best_selling_products($limit = 8) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC'
    );

    return new WP_Query($args);
}

/**
 * Function to get products from a specific category
 */
function remotestore_get_products_by_category($category_id, $limit = 8) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        ),
    );

    return new WP_Query($args);
}

/**
 * Function to get product categories
 */
function remotestore_get_product_categories($limit = -1) {
    $args = array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'number'     => $limit,
        'orderby'    => 'name',
        'order'      => 'ASC'
    );

    return get_terms($args);
}

/**
 * Add shop sidebar
 */
function remotestore_woocommerce_sidebar() {
    if (is_shop() || is_product_category() || is_product_tag()) {
        get_sidebar('shop');
    }
}
add_action('woocommerce_sidebar', 'remotestore_woocommerce_sidebar');

/**
 * Modify breadcrumb settings - without using translation functions
 */
function remotestore_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' <i class="fas fa-chevron-right"></i> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => 'Home', // Hardcoded to avoid translation function
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'remotestore_woocommerce_breadcrumbs');
