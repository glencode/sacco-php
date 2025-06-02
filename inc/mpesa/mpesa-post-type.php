<?php
/**
 * M-Pesa Post Type
 *
 * @package daystar-website-fixes
 */

/**
 * Register custom post type for M-Pesa transactions
 */
function daystar_register_mpesa_transaction_post_type() {
    $labels = array(
        'name'               => 'M-Pesa Transactions',
        'singular_name'      => 'M-Pesa Transaction',
        'menu_name'          => 'M-Pesa Transactions',
        'name_admin_bar'     => 'M-Pesa Transaction',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Transaction',
        'new_item'           => 'New Transaction',
        'edit_item'          => 'Edit Transaction',
        'view_item'          => 'View Transaction',
        'all_items'          => 'All Transactions',
        'search_items'       => 'Search Transactions',
        'parent_item_colon'  => 'Parent Transactions:',
        'not_found'          => 'No transactions found.',
        'not_found_in_trash' => 'No transactions found in Trash.'
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title')
    );
    
    register_post_type('mpesa_transaction', $args);
}
add_action('init', 'daystar_register_mpesa_transaction_post_type');

/**
 * Add custom meta boxes for M-Pesa transactions
 */
function daystar_add_mpesa_transaction_meta_boxes() {
    add_meta_box(
        'mpesa_transaction_details',
        'Transaction Details',
        'daystar_mpesa_transaction_details_callback',
        'mpesa_transaction',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'daystar_add_mpesa_transaction_meta_boxes');

/**
 * M-Pesa transaction details meta box callback
 */
function daystar_mpesa_transaction_details_callback($post) {
    $transaction_type = get_post_meta($post->ID, '_transaction_type', true);
    $amount = get_post_meta($post->ID, '_amount', true);
    $phone = get_post_meta($post->ID, '_phone', true);
    $reference = get_post_meta($post->ID, '_reference', true);
    $mpesa_receipt = get_post_meta($post->ID, '_mpesa_receipt', true);
    $checkout_request_id = get_post_meta($post->ID, '_checkout_request_id', true);
    $status = get_post_meta($post->ID, '_status', true);
    $user_id = get_post_meta($post->ID, '_user_id', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="transaction_type">Transaction Type</label></th>
            <td><?php echo esc_html($transaction_type); ?></td>
        </tr>
        <tr>
            <th><label for="amount">Amount</label></th>
            <td>KSh <?php echo esc_html(number_format($amount, 2)); ?></td>
        </tr>
        <tr>
            <th><label for="phone">Phone Number</label></th>
            <td><?php echo esc_html($phone); ?></td>
        </tr>
        <tr>
            <th><label for="reference">Reference</label></th>
            <td><?php echo esc_html($reference); ?></td>
        </tr>
        <tr>
            <th><label for="mpesa_receipt">M-Pesa Receipt</label></th>
            <td><?php echo esc_html($mpesa_receipt); ?></td>
        </tr>
        <tr>
            <th><label for="checkout_request_id">Checkout Request ID</label></th>
            <td><?php echo esc_html($checkout_request_id); ?></td>
        </tr>
        <tr>
            <th><label for="status">Status</label></th>
            <td>
                <?php
                $status_class = '';
                switch ($status) {
                    case 'pending':
                        $status_class = 'pending';
                        break;
                    case 'completed':
                        $status_class = 'completed';
                        break;
                    case 'failed':
                        $status_class = 'failed';
                        break;
                }
                ?>
                <span class="status-<?php echo $status_class; ?>"><?php echo esc_html(ucfirst($status)); ?></span>
            </td>
        </tr>
        <tr>
            <th><label for="user_id">User</label></th>
            <td>
                <?php
                if ($user_id) {
                    $user = get_user_by('id', $user_id);
                    if ($user) {
                        echo '<a href="' . esc_url(get_edit_user_link($user_id)) . '">' . esc_html($user->display_name) . ' (' . esc_html($user->user_email) . ')</a>';
                    } else {
                        echo 'User not found';
                    }
                } else {
                    echo 'Guest';
                }
                ?>
            </td>
        </tr>
    </table>
    <style>
        .status-pending {
            background-color: #f8dda7;
            color: #94660c;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-completed {
            background-color: #c6e1c6;
            color: #5b841b;
            padding: 3px 8px;
            border-radius: 3px;
        }
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 3px;
        }
    </style>
    <?php
}
