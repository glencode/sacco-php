/**
 * Notifications JavaScript functionality
 */

// Mark all notifications as read
function markAllNotificationsRead() {
    // Get current user ID from PHP
    const userId = daystarData.userId;
    
    // Make AJAX request to mark all notifications as read
    jQuery.ajax({
        url: daystarData.ajaxUrl,
        type: 'POST',
        data: {
            action: 'mark_all_notifications_read',
            user_id: userId,
            nonce: daystarData.nonce
        },
        success: function(response) {
            if (response.success) {
                // Update notification badge
                jQuery('.notification-badge').text('0');
                
                // Remove unread class from all notifications
                jQuery('.notification-item').removeClass('unread');
                
                // Show success message
                showNotificationMessage('All notifications marked as read', 'success');
            } else {
                showNotificationMessage('Error marking notifications as read', 'error');
            }
        },
        error: function() {
            showNotificationMessage('Error marking notifications as read', 'error');
        }
    });
}

// Show notification message
function showNotificationMessage(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>`;
    
    // Insert alert at top of dashboard
    jQuery('.dashboard-content').prepend(alertHtml);
    
    // Auto-hide after 3 seconds
    setTimeout(function() {
        jQuery('.alert').fadeOut();
    }, 3000);
}

// Initialize notifications functionality
jQuery(document).ready(function($) {
    // Handle notification dropdown toggle
    $('.notification-bell').on('click', function(e) {
        e.stopPropagation();
        $('.notification-dropdown').toggle();
    });
    
    // Close dropdown when clicking outside
    $(document).on('click', function() {
        $('.notification-dropdown').hide();
    });
    
    // Prevent dropdown from closing when clicking inside
    $('.notification-dropdown').on('click', function(e) {
        e.stopPropagation();
    });
});