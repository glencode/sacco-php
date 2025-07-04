<?php
/**
 * Member Documents Management
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Member Documents Post Type
 */
function daystar_register_member_documents_post_type() {
    $labels = array(
        'name'                  => 'Member Documents',
        'singular_name'         => 'Member Document',
        'menu_name'            => 'Member Documents',
        'add_new'              => 'Add New',
        'add_new_item'         => 'Add New Document',
        'edit_item'            => 'Edit Document',
        'new_item'             => 'New Document',
        'view_item'            => 'View Document',
        'search_items'         => 'Search Documents',
        'not_found'            => 'No documents found',
        'not_found_in_trash'   => 'No documents found in trash'
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => 'daystar-admin-dashboard',
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'rewrite'            => false,
        'supports'           => array('title'),
        'show_in_rest'       => false
    );

    register_post_type('member_document', $args);
}
add_action('init', 'daystar_register_member_documents_post_type');

/**
 * Register document types taxonomy
 */
function daystar_register_document_types_taxonomy() {
    $labels = array(
        'name'              => 'Document Types',
        'singular_name'     => 'Document Type',
        'search_items'      => 'Search Document Types',
        'all_items'         => 'All Document Types',
        'edit_item'         => 'Edit Document Type',
        'update_item'       => 'Update Document Type',
        'add_new_item'      => 'Add New Document Type',
        'new_item_name'     => 'New Document Type Name',
        'menu_name'         => 'Document Types'
    );

    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'          => true,
        'show_admin_column' => true,
        'query_var'        => true,
        'show_in_rest'     => false
    );

    register_taxonomy('document_type', array('member_document'), $args);

    // Add default document types
    $default_types = array(
        'national-id' => 'National ID',
        'passport' => 'Passport',
        'payslip' => 'Payslip',
        'bank-statement' => 'Bank Statement',
        'proof-of-residence' => 'Proof of Residence',
        'profile-photo' => 'Profile Photo'
    );

    foreach ($default_types as $slug => $name) {
        if (!term_exists($slug, 'document_type')) {
            wp_insert_term($name, 'document_type', array('slug' => $slug));
        }
    }
}
add_action('init', 'daystar_register_document_types_taxonomy');

/**
 * Handle document upload
 */
function daystar_handle_document_upload() {
    check_ajax_referer('daystar_document_upload', 'security');

    if (!is_user_logged_in()) {
        wp_send_json_error('Not authorized');
    }

    $user_id = get_current_user_id();
    $document_type = isset($_POST['document_type']) ? sanitize_text_field($_POST['document_type']) : '';
    
    if (empty($document_type) || empty($_FILES['document'])) {
        wp_send_json_error('Missing required data');
    }

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $upload = wp_handle_upload($_FILES['document'], array('test_form' => false));

    if (isset($upload['error'])) {
        wp_send_json_error($upload['error']);
    }

    // Create document post
    $document_title = $document_type . ' - ' . get_userdata($user_id)->display_name;
    $document_post = array(
        'post_title'    => $document_title,
        'post_status'   => 'private',
        'post_type'     => 'member_document',
        'post_author'   => $user_id
    );

    $doc_id = wp_insert_post($document_post);

    if (is_wp_error($doc_id)) {
        wp_send_json_error($doc_id->get_error_message());
    }

    // Save file URL
    update_post_meta($doc_id, '_document_url', $upload['url']);
    wp_set_object_terms($doc_id, $document_type, 'document_type');
    update_post_meta($doc_id, '_member_id', $user_id);

    wp_send_json_success(array(
        'message' => 'Document uploaded successfully',
        'doc_id' => $doc_id
    ));
}
add_action('wp_ajax_daystar_upload_document', 'daystar_handle_document_upload');

/**
 * Get member documents
 */
function daystar_get_member_documents($user_id) {
    $args = array(
        'post_type' => 'member_document',
        'posts_per_page' => -1,
        'post_status' => 'private',
        'meta_query' => array(
            array(
                'key' => '_member_id',
                'value' => $user_id
            )
        )
    );

    $documents = array();
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $doc_type = wp_get_post_terms(get_the_ID(), 'document_type');
            $documents[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'type' => !empty($doc_type) ? $doc_type[0]->name : '',
                'url' => get_post_meta(get_the_ID(), '_document_url', true),
                'date' => get_the_date('Y-m-d H:i:s')
            );
        }
    }
    wp_reset_postdata();

    return $documents;
}
