<?php
/**
 * Award Custom Post Type
 */

class Award_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('Awards', 'daystar'),
            'singular_name'      => __('Award', 'daystar'),
            'menu_name'          => __('Awards', 'daystar'),
            'add_new'            => __('Add New', 'daystar'),
            'add_new_item'       => __('Add New Award', 'daystar'),
            'edit_item'          => __('Edit Award', 'daystar'),
            'new_item'           => __('New Award', 'daystar'),
            'view_item'          => __('View Award', 'daystar'),
            'search_items'       => __('Search Awards', 'daystar'),
            'not_found'          => __('No awards found', 'daystar'),
            'not_found_in_trash' => __('No awards found in trash', 'daystar')
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
            'menu_icon'           => 'dashicons-awards',
            'rewrite'             => array('slug' => 'awards')
        );

        register_post_type('award', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'award_details',
            __('Award Details', 'daystar'),
            array($this, 'render_meta_box'),
            'award',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('award_meta_box', 'award_meta_box_nonce');
        $award_date = get_post_meta($post->ID, '_award_date', true);
        $award_presenter = get_post_meta($post->ID, '_award_presenter', true);
        ?>
        <p>
            <label for="award_date"><?php _e('Award Date', 'daystar'); ?></label>
            <input type="date" id="award_date" name="award_date" value="<?php echo esc_attr($award_date); ?>">
        </p>
        <p>
            <label for="award_presenter"><?php _e('Award Presenter/Organization', 'daystar'); ?></label>
            <input type="text" id="award_presenter" name="award_presenter" value="<?php echo esc_attr($award_presenter); ?>" style="width: 100%;">
        </p>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['award_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['award_meta_box_nonce'], 'award_meta_box')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['award_date'])) {
            update_post_meta($post_id, '_award_date', sanitize_text_field($_POST['award_date']));
        }
        if (isset($_POST['award_presenter'])) {
            update_post_meta($post_id, '_award_presenter', sanitize_text_field($_POST['award_presenter']));
        }
    }
}

new Award_CPT();
