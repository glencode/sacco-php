<?php
/**
 * Loan Custom Post Type
 */

class Loan_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('Loan Products', 'daystar'),
            'singular_name'      => __('Loan Product', 'daystar'),
            'menu_name'          => __('Loan Products', 'daystar'),
            'add_new'            => __('Add New', 'daystar'),
            'add_new_item'       => __('Add New Loan Product', 'daystar'),
            'edit_item'          => __('Edit Loan Product', 'daystar'),
            'new_item'           => __('New Loan Product', 'daystar'),
            'view_item'          => __('View Loan Product', 'daystar'),
            'search_items'       => __('Search Loan Products', 'daystar'),
            'not_found'          => __('No loan products found', 'daystar'),
            'not_found_in_trash' => __('No loan products found in trash', 'daystar')
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
            'menu_icon'           => 'dashicons-money-alt',
            'rewrite'             => array('slug' => 'loan-products')
        );

        register_post_type('loan', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'loan_details',
            __('Loan Product Details', 'daystar'),
            array($this, 'render_meta_box'),
            'loan',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('loan_meta_box', 'loan_meta_box_nonce');
        
        $interest_rate = get_post_meta($post->ID, '_interest_rate', true);
        $minimum_amount = get_post_meta($post->ID, '_minimum_amount', true);
        $maximum_amount = get_post_meta($post->ID, '_maximum_amount', true);
        $repayment_period = get_post_meta($post->ID, '_repayment_period', true);
        $requirements = get_post_meta($post->ID, '_requirements', true);
        $security_required = get_post_meta($post->ID, '_security_required', true);
        ?>
        <p>
            <label for="interest_rate"><?php _e('Interest Rate (% per annum)', 'daystar'); ?></label>
            <input type="number" id="interest_rate" name="interest_rate" value="<?php echo esc_attr($interest_rate); ?>" step="0.01">
        </p>
        <p>
            <label for="minimum_amount"><?php _e('Minimum Amount (KES)', 'daystar'); ?></label>
            <input type="number" id="minimum_amount" name="minimum_amount" value="<?php echo esc_attr($minimum_amount); ?>" step="1000">
        </p>
        <p>
            <label for="maximum_amount"><?php _e('Maximum Amount (KES)', 'daystar'); ?></label>
            <input type="number" id="maximum_amount" name="maximum_amount" value="<?php echo esc_attr($maximum_amount); ?>" step="1000">
        </p>
        <p>
            <label for="repayment_period"><?php _e('Maximum Repayment Period (months)', 'daystar'); ?></label>
            <input type="number" id="repayment_period" name="repayment_period" value="<?php echo esc_attr($repayment_period); ?>">
        </p>
        <p>
            <label for="requirements"><?php _e('Requirements', 'daystar'); ?></label>
            <textarea id="requirements" name="requirements" rows="5" style="width: 100%;"><?php echo esc_textarea($requirements); ?></textarea>
        </p>
        <p>
            <label for="security_required"><?php _e('Security Required', 'daystar'); ?></label>
            <textarea id="security_required" name="security_required" rows="3" style="width: 100%;"><?php echo esc_textarea($security_required); ?></textarea>
        </p>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['loan_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['loan_meta_box_nonce'], 'loan_meta_box')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $fields = array(
            'interest_rate',
            'minimum_amount',
            'maximum_amount',
            'repayment_period',
            'requirements',
            'security_required'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                if (in_array($field, array('requirements', 'security_required'))) {
                    update_post_meta($post_id, '_' . $field, wp_kses_post($_POST[$field]));
                } else {
                    update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
                }
            }
        }
    }
}

new Loan_CPT();
