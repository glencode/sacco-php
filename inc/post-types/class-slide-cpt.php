<?php
/**
 * Slide Custom Post Type
 */

class Slide_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('Slides', 'daystar'),
            'singular_name'      => __('Slide', 'daystar'),
            'menu_name'          => __('Slider', 'daystar'),
            'add_new'            => __('Add New', 'daystar'),
            'add_new_item'       => __('Add New Slide', 'daystar'),
            'edit_item'          => __('Edit Slide', 'daystar'),
            'new_item'           => __('New Slide', 'daystar'),
            'view_item'          => __('View Slide', 'daystar'),
            'search_items'       => __('Search Slides', 'daystar'),
            'not_found'          => __('No slides found', 'daystar'),
            'not_found_in_trash' => __('No slides found in trash', 'daystar')
        );

        $args = array(
            'labels'              => $labels,
            'public'              => true,
            'has_archive'         => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_rest'        => true,
            'supports'            => array('title', 'thumbnail'),
            'menu_icon'           => 'dashicons-slides',
            'rewrite'             => array('slug' => 'slides')
        );

        register_post_type('slide', $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'slide_details',
            __('Slide Details', 'daystar'),
            array($this, 'render_meta_box'),
            'slide',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('slide_meta_box', 'slide_meta_box_nonce');
        
        $heading = get_post_meta($post->ID, '_slide_heading', true);
        $subheading = get_post_meta($post->ID, '_slide_subheading', true);
        $button_text = get_post_meta($post->ID, '_button_text', true);
        $button_url = get_post_meta($post->ID, '_button_url', true);
        $slide_order = get_post_meta($post->ID, '_slide_order', true);
        ?>
        <p>
            <label for="slide_heading"><?php _e('Heading', 'daystar'); ?></label>
            <input type="text" id="slide_heading" name="slide_heading" value="<?php echo esc_attr($heading); ?>" style="width: 100%;">
        </p>
        <p>
            <label for="slide_subheading"><?php _e('Subheading', 'daystar'); ?></label>
            <textarea id="slide_subheading" name="slide_subheading" rows="2" style="width: 100%;"><?php echo esc_textarea($subheading); ?></textarea>
        </p>
        <p>
            <label for="button_text"><?php _e('Button Text', 'daystar'); ?></label>
            <input type="text" id="button_text" name="button_text" value="<?php echo esc_attr($button_text); ?>">
        </p>
        <p>
            <label for="button_url"><?php _e('Button URL', 'daystar'); ?></label>
            <input type="url" id="button_url" name="button_url" value="<?php echo esc_attr($button_url); ?>" style="width: 100%;">
        </p>
        <p>
            <label for="slide_order"><?php _e('Slide Order', 'daystar'); ?></label>
            <input type="number" id="slide_order" name="slide_order" value="<?php echo esc_attr($slide_order); ?>" min="0" step="1">
        </p>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['slide_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['slide_meta_box_nonce'], 'slide_meta_box')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $fields = array(
            'slide_heading',
            'slide_subheading',
            'button_text',
            'button_url',
            'slide_order'
        );

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }
}

new Slide_CPT();
