<?php
/**
 * Download Custom Post Type
 */

class Download_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomy'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
    }

    public function register_post_type() {
        $labels = array(
            'name'               => __('Downloads', 'daystar'),
            'singular_name'      => __('Download', 'daystar'),
            'menu_name'          => __('Downloads', 'daystar'),
            'add_new'            => __('Add New', 'daystar'),
            'add_new_item'       => __('Add New Download', 'daystar'),
            'edit_item'          => __('Edit Download', 'daystar'),
            'new_item'           => __('New Download', 'daystar'),
            'view_item'          => __('View Download', 'daystar'),
            'search_items'       => __('Search Downloads', 'daystar'),
            'not_found'          => __('No downloads found', 'daystar'),
            'not_found_in_trash' => __('No downloads found in trash', 'daystar')
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
            'menu_icon'           => 'dashicons-download',
            'rewrite'             => array('slug' => 'downloads')
        );

        register_post_type('download', $args);
    }

    public function register_taxonomy() {
        $labels = array(
            'name'              => __('Resource Types', 'daystar'),
            'singular_name'     => __('Resource Type', 'daystar'),
            'search_items'      => __('Search Resource Types', 'daystar'),
            'all_items'         => __('All Resource Types', 'daystar'),
            'parent_item'       => __('Parent Resource Type', 'daystar'),
            'parent_item_colon' => __('Parent Resource Type:', 'daystar'),
            'edit_item'         => __('Edit Resource Type', 'daystar'),
            'update_item'       => __('Update Resource Type', 'daystar'),
            'add_new_item'      => __('Add New Resource Type', 'daystar'),
            'new_item_name'     => __('New Resource Type Name', 'daystar'),
            'menu_name'         => __('Resource Types', 'daystar'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => 'resource-type'),
        );

        register_taxonomy('resource_type', array('download'), $args);
    }

    public function add_meta_boxes() {
        add_meta_box(
            'download_details',
            __('Download Details', 'daystar'),
            array($this, 'render_meta_box'),
            'download',
            'normal',
            'high'
        );
    }

    public function render_meta_box($post) {
        wp_nonce_field('download_meta_box', 'download_meta_box_nonce');
        $file_url = get_post_meta($post->ID, '_file_url', true);
        ?>
        <p>
            <label for="file_url"><?php _e('File URL', 'daystar'); ?></label>
            <input type="text" id="file_url" name="file_url" value="<?php echo esc_attr($file_url); ?>" style="width: 100%;">
            <button type="button" class="button" id="upload_file_button"><?php _e('Upload File', 'daystar'); ?></button>
        </p>
        <script>
            jQuery(document).ready(function($) {
                $('#upload_file_button').click(function(e) {
                    e.preventDefault();
                    var custom_uploader = wp.media({
                        title: '<?php _e("Choose File", "daystar"); ?>',
                        button: {
                            text: '<?php _e("Choose File", "daystar"); ?>'
                        },
                        multiple: false
                    });
                    custom_uploader.on('select', function() {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        $('#file_url').val(attachment.url);
                    });
                    custom_uploader.open();
                });
            });
        </script>
        <?php
    }

    public function save_meta_boxes($post_id) {
        if (!isset($_POST['download_meta_box_nonce'])) {
            return;
        }
        if (!wp_verify_nonce($_POST['download_meta_box_nonce'], 'download_meta_box')) {
            return;
        }
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST['file_url'])) {
            update_post_meta($post_id, '_file_url', esc_url_raw($_POST['file_url']));
        }
    }
}

new Download_CPT();
