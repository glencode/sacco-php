<?php
/**
 * Savings Custom Post Type
 */

class Savings_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('Savings Products', 'daystar'),
            'singular_name'      => __('Savings Product', 'daystar'),
            'menu_name'          => __('Savings Products', 'daystar'),
            'add_new'            => __('Add New', 'daystar'),
            'add_new_item'       => __('Add New Savings Product', 'daystar'),
            'edit_item'          => __('Edit Savings Product', 'daystar'),
            'new_item'           => __('New Savings Product', 'daystar'),
            'view_item'          => __('View Savings Product', 'daystar'),
            'search_items'       => __('Search Savings Products', 'daystar'),
            'not_found'          => __('No savings products found', 'daystar'),
            'not_found_in_trash' => __('No savings products found in trash', 'daystar')
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
            'menu_icon'           => 'dashicons-vault',
            'rewrite'             => array('slug' => 'savings-products')
        );

        register_post_type('savings', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'savings_details',
            __('Savings Product Details', 'daystar'),
            array($this, 'render_meta_box'),
            'savings',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('savings_meta_box', 'savings_meta_box_nonce');
        
        $interest_rate = get_post_meta($post->ID, '_interest_rate', true);
        $minimum_deposit = get_post_meta($post->ID, '_minimum_deposit', true);
        $maximum_deposit = get_post_meta($post->ID, '_maximum_deposit', true);
        $withdrawal_terms = get_post_meta($post->ID, '_withdrawal_terms', true);
        $maturity_period = get_post_meta($post->ID, '_maturity_period', true);
        ?>
        <p>
            <label for="interest_rate"><?php _e('Interest Rate (%)', 'daystar'); ?></label>
            <input type="number" id="interest_rate" name="interest_rate" value="<?php echo esc_attr($interest_rate); ?>" step="0.01">
        </p>
        <p>
            <label for="minimum_deposit"><?php _e('Minimum Deposit (KES)', 'daystar'); ?></label>
            <input type="number" id="minimum_deposit" name="minimum_deposit" value="<?php echo esc_attr($minimum_deposit); ?>" step="100">
        </p>
        <p>
            <label for="maximum_deposit"><?php _e('Maximum Deposit (KES)', 'daystar'); ?></label>
            <input type="number" id="maximum_deposit" name="maximum_deposit" value="<?php echo esc_attr($maximum_deposit); ?>" step="100">
        </p>
        <p>
            <label for="withdrawal_terms"><?php _e('Withdrawal Terms', 'daystar'); ?></label>
            <textarea id="withdrawal_terms" name="withdrawal_terms" rows="3" style="width: 100%;"><?php echo esc_textarea($withdrawal_terms); ?></textarea>
        </p>
        <p>
            <label for="maturity_period"><?php _e('Maturity Period (months)', 'daystar'); ?></label>
            <input type="number" id="maturity_period" name="maturity_period" value="<?php echo esc_attr($maturity_period); ?>">
        </p>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['savings_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['savings_meta_box_nonce'], 'savings_meta_box')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $fields = array(
            'interest_rate',
            'minimum_deposit',
            'maximum_deposit',
            'withdrawal_terms',
            'maturity_period'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                if ($field === 'withdrawal_terms') {
                    update_post_meta($post_id, '_' . $field, wp_kses_post($_POST[$field]));
                } else {
                    update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
                }
            }
        }
    }
}

new Savings_CPT();
