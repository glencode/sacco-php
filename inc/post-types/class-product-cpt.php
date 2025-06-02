<?php
/**
 * Product Custom Post Type
 */

class Product_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('Products', 'daystar'),
            'singular_name'      => __('Product', 'daystar'),
            'menu_name'         => __('Products', 'daystar'),
            'add_new'           => __('Add New', 'daystar'),
            'add_new_item'      => __('Add New Product', 'daystar'),
            'edit_item'         => __('Edit Product', 'daystar'),
            'new_item'          => __('New Product', 'daystar'),
            'view_item'         => __('View Product', 'daystar'),
            'search_items'      => __('Search Products', 'daystar'),
            'not_found'         => __('No products found', 'daystar'),
            'not_found_in_trash'=> __('No products found in trash', 'daystar')
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon'           => 'dashicons-products',
            'rewrite'             => array('slug' => 'products')
        );

        register_post_type('product', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'product_details',
            __('Product Details', 'daystar'),
            array($this, 'render_meta_box'),
            'product',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('product_meta_box', 'product_meta_box_nonce');
        $product_rate = get_post_meta($post->ID, '_product_rate', true);
        $product_terms = get_post_meta($post->ID, '_product_terms', true);
        ?>
        <p>
            <label for="product_rate"><?php _e('Interest Rate (%)', 'daystar'); ?></label>
            <input type="text" id="product_rate" name="product_rate" value="<?php echo esc_attr($product_rate); ?>">
        </p>
        <p>
            <label for="product_terms"><?php _e('Terms & Conditions', 'daystar'); ?></label>
            <textarea id="product_terms" name="product_terms" rows="5" cols="50"><?php echo esc_textarea($product_terms); ?></textarea>
        </p>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['product_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['product_meta_box_nonce'], 'product_meta_box')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['product_rate'])) {
            update_post_meta($post_id, '_product_rate', sanitize_text_field($_POST['product_rate']));
        }
        if (isset($_POST['product_terms'])) {
            update_post_meta($post_id, '_product_terms', wp_kses_post($_POST['product_terms']));
        }
    }
}

new Product_CPT();
