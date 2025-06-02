<?php
/**
 * Partner Custom Post Type
 */

class Partner_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('Partners', 'daystar'),
            'singular_name'      => __('Partner', 'daystar'),
            'menu_name'          => __('Partners', 'daystar'),
            'add_new'            => __('Add New', 'daystar'),
            'add_new_item'       => __('Add New Partner', 'daystar'),
            'edit_item'          => __('Edit Partner', 'daystar'),
            'new_item'           => __('New Partner', 'daystar'),
            'view_item'          => __('View Partner', 'daystar'),
            'search_items'       => __('Search Partners', 'daystar'),
            'not_found'          => __('No partners found', 'daystar'),
            'not_found_in_trash' => __('No partners found in trash', 'daystar')
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'supports'            => array('title', 'editor', 'thumbnail'),
            'menu_icon'           => 'dashicons-groups',
            'rewrite'             => array('slug' => 'partners')
        );

        register_post_type('partner', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'partner_details',
            __('Partner Details', 'daystar'),
            array($this, 'render_meta_box'),
            'partner',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('partner_meta_box', 'partner_meta_box_nonce');
        $website_url = get_post_meta($post->ID, '_website_url', true);
        $partnership_type = get_post_meta($post->ID, '_partnership_type', true);
        ?>
        <p>
            <label for="website_url"><?php _e('Website URL', 'daystar'); ?></label>
            <input type="url" id="website_url" name="website_url" value="<?php echo esc_attr($website_url); ?>" style="width: 100%;">
        </p>
        <p>
            <label for="partnership_type"><?php _e('Partnership Type', 'daystar'); ?></label>
            <select id="partnership_type" name="partnership_type">
                <option value="strategic" <?php selected($partnership_type, 'strategic'); ?>><?php _e('Strategic Partner', 'daystar'); ?></option>
                <option value="technology" <?php selected($partnership_type, 'technology'); ?>><?php _e('Technology Partner', 'daystar'); ?></option>
                <option value="financial" <?php selected($partnership_type, 'financial'); ?>><?php _e('Financial Institution', 'daystar'); ?></option>
                <option value="community" <?php selected($partnership_type, 'community'); ?>><?php _e('Community Partner', 'daystar'); ?></option>
            </select>
        </p>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['partner_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['partner_meta_box_nonce'], 'partner_meta_box')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['website_url'])) {
            update_post_meta($post_id, '_website_url', esc_url_raw($_POST['website_url']));
        }
        if (isset($_POST['partnership_type'])) {
            update_post_meta($post_id, '_partnership_type', sanitize_text_field($_POST['partnership_type']));
        }
    }
}

new Partner_CPT();
