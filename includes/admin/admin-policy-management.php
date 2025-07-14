<?php
/**
 * Admin Policy Management Interface
 * 
 * Provides admin interface for managing credit policies including:
 * - Policy version creation and editing
 * - Publishing and archiving policies
 * - Version comparison and audit trails
 * - Policy document generation
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once get_template_directory() . '/includes/policy-management.php';

/**
 * Admin Policy Management Page
 */
function daystar_admin_policy_management_page() {
    global $wpdb;
    
    // Get current view
    $view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'policies';
    $policy_id = isset($_GET['policy_id']) ? intval($_GET['policy_id']) : 0;
    
    ?>
    <div class="wrap">
        <h1>Policy Management</h1>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($_GET['message']); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="notice notice-error is-dismissible">
                <p><?php echo esc_html($_GET['error']); ?></p>
            </div>
        <?php endif; ?>
        
        <nav class="nav-tab-wrapper">
            <a href="?page=daystar-admin-policy&view=policies" 
               class="nav-tab <?php echo $view === 'policies' ? 'nav-tab-active' : ''; ?>">
                Policy Versions
            </a>
            <a href="?page=daystar-admin-policy&view=create" 
               class="nav-tab <?php echo $view === 'create' ? 'nav-tab-active' : ''; ?>">
                Create New Version
            </a>
            <a href="?page=daystar-admin-policy&view=compare" 
               class="nav-tab <?php echo $view === 'compare' ? 'nav-tab-active' : ''; ?>">
                Compare Versions
            </a>
            <a href="?page=daystar-admin-policy&view=audit" 
               class="nav-tab <?php echo $view === 'audit' ? 'nav-tab-active' : ''; ?>">
                Audit Trail
            </a>
        </nav>
        
        <div class="tab-content">
            <?php
            switch ($view) {
                case 'policies':
                    display_policy_versions_tab();
                    break;
                case 'create':
                    display_create_policy_tab();
                    break;
                case 'edit':
                    if ($policy_id) {
                        display_edit_policy_tab($policy_id);
                    } else {
                        display_policy_versions_tab();
                    }
                    break;
                case 'compare':
                    display_compare_versions_tab();
                    break;
                case 'audit':
                    display_audit_trail_tab();
                    break;
                default:
                    display_policy_versions_tab();
            }
            ?>
        </div>
    </div>
    
    <style>
    .policy-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .policy-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    .policy-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    
    .status-draft { background: #fff3cd; color: #856404; }
    .status-published { background: #d4edda; color: #155724; }
    .status-archived { background: #f8d7da; color: #721c24; }
    
    .policy-content {
        max-height: 200px;
        overflow-y: auto;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin: 15px 0;
        font-family: monospace;
        font-size: 14px;
        line-height: 1.4;
    }
    
    .policy-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 15px;
    }
    
    .version-comparison {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }
    
    .version-panel {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
    }
    
    .diff-line {
        padding: 2px 5px;
        margin: 1px 0;
        font-family: monospace;
        font-size: 13px;
    }
    
    .diff-added { background: #d4edda; color: #155724; }
    .diff-removed { background: #f8d7da; color: #721c24; }
    .diff-modified { background: #fff3cd; color: #856404; }
    
    .audit-entry {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 10px;
        background: #fff;
    }
    
    .audit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-weight: bold;
    }
    
    .audit-details {
        font-size: 14px;
        color: #666;
    }
    
    .policy-editor {
        width: 100%;
        min-height: 400px;
        font-family: monospace;
        font-size: 14px;
        line-height: 1.4;
    }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Create policy version
        $('#create-policy-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = {
                action: 'create_policy_version',
                nonce: '<?php echo wp_create_nonce('policy_management_nonce'); ?>',
                title: $('#policy_title').val(),
                version_number: $('#version_number').val(),
                content: $('#policy_content').val(),
                effective_date: $('#effective_date').val()
            };
            
            $.post(ajaxurl, formData, function(response) {
                if (response.success) {
                    alert('Policy version created successfully!');
                    window.location.href = '?page=daystar-admin-policy&view=policies';
                } else {
                    alert('Error: ' + response.message);
                }
            });
        });
        
        // Update policy version
        $('#update-policy-form').on('submit', function(e) {
            e.preventDefault();
            
            var formData = {
                action: 'update_policy_version',
                nonce: '<?php echo wp_create_nonce('policy_management_nonce'); ?>',
                policy_id: $('#policy_id').val(),
                title: $('#policy_title').val(),
                content: $('#policy_content').val(),
                effective_date: $('#effective_date').val()
            };
            
            $.post(ajaxurl, formData, function(response) {
                if (response.success) {
                    alert('Policy version updated successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            });
        });
        
        // Publish policy
        $('.publish-policy').on('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to publish this policy version? This will notify all members.')) {
                return;
            }
            
            var policyId = $(this).data('policy-id');
            
            $.post(ajaxurl, {
                action: 'publish_policy_version',
                nonce: '<?php echo wp_create_nonce('policy_management_nonce'); ?>',
                policy_id: policyId
            }, function(response) {
                if (response.success) {
                    alert('Policy version published successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            });
        });
        
        // Archive policy
        $('.archive-policy').on('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Are you sure you want to archive this policy version?')) {
                return;
            }
            
            var policyId = $(this).data('policy-id');
            
            $.post(ajaxurl, {
                action: 'archive_policy_version',
                nonce: '<?php echo wp_create_nonce('policy_management_nonce'); ?>',
                policy_id: policyId
            }, function(response) {
                if (response.success) {
                    alert('Policy version archived successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            });
        });
        
        // Compare versions
        $('#compare-versions-form').on('submit', function(e) {
            e.preventDefault();
            
            var version1 = $('#version1_select').val();
            var version2 = $('#version2_select').val();
            
            if (version1 === version2) {
                alert('Please select two different versions to compare.');
                return;
            }
            
            $.post(ajaxurl, {
                action: 'compare_policy_versions',
                nonce: '<?php echo wp_create_nonce('policy_management_nonce'); ?>',
                version1_id: version1,
                version2_id: version2
            }, function(response) {
                if (response.success) {
                    displayVersionComparison(response);
                } else {
                    alert('Error: ' + response.message);
                }
            });
        });
        
        // Generate PDF
        $('.generate-pdf').on('click', function(e) {
            e.preventDefault();
            
            var policyId = $(this).data('policy-id');
            
            $.post(ajaxurl, {
                action: 'generate_policy_pdf',
                nonce: '<?php echo wp_create_nonce('policy_management_nonce'); ?>',
                policy_id: policyId
            }, function(response) {
                if (response.success) {
                    window.open(response.file_path, '_blank');
                } else {
                    alert('Error: ' + response.message);
                }
            });
        });
        
        // Setup sample policy
        $('#setup-sample-policy').on('click', function(e) {
            e.preventDefault();
            
            if (!confirm('This will create and publish a sample credit policy. Continue?')) {
                return;
            }
            
            $(this).prop('disabled', true).text('Setting up...');
            
            $.post(ajaxurl, {
                action: 'setup_sample_policy',
                nonce: '<?php echo wp_create_nonce('policy_management_nonce'); ?>'
            }, function(response) {
                if (response.success) {
                    alert('Sample policy created and published successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + response.message);
                    $('#setup-sample-policy').prop('disabled', false).text('Set up sample policy automatically');
                }
            });
        });
        
        function displayVersionComparison(response) {
            var html = '<div class="version-comparison">';
            
            // Version 1 panel
            html += '<div class="version-panel">';
            html += '<h3>Version ' + response.version1.version_number + '</h3>';
            html += '<p><strong>Created:</strong> ' + response.version1.created_at + '</p>';
            html += '<p><strong>Status:</strong> ' + response.version1.status + '</p>';
            html += '</div>';
            
            // Version 2 panel
            html += '<div class="version-panel">';
            html += '<h3>Version ' + response.version2.version_number + '</h3>';
            html += '<p><strong>Created:</strong> ' + response.version2.created_at + '</p>';
            html += '<p><strong>Status:</strong> ' + response.version2.status + '</p>';
            html += '</div>';
            
            html += '</div>';
            
            // Differences
            if (response.diff.length > 0) {
                html += '<h3>Differences</h3>';
                html += '<div class="diff-container">';
                
                response.diff.forEach(function(diff) {
                    html += '<div class="diff-line diff-' + diff.type + '">';
                    html += 'Line ' + diff.line + ': ';
                    if (diff.type === 'removed') {
                        html += '- ' + diff.old;
                    } else if (diff.type === 'added') {
                        html += '+ ' + diff.new;
                    } else {
                        html += '~ ' + diff.old + ' → ' + diff.new;
                    }
                    html += '</div>';
                });
                
                html += '</div>';
            } else {
                html += '<p>No differences found between the selected versions.</p>';
            }
            
            $('#comparison-results').html(html);
        }
    });
    </script>
    <?php
}

/**
 * Display policy versions tab
 */
function display_policy_versions_tab() {
    $policies = get_policy_versions();
    
    ?>
    <div class="policy-card">
        <div class="policy-header">
            <h3>Policy Versions</h3>
            <a href="?page=daystar-admin-policy&view=create" class="button button-primary">Create New Version</a>
        </div>
        
        <?php if (empty($policies)): ?>
            <div class="notice notice-info">
                <p><strong>No policy versions found.</strong></p>
                <p>You can either:</p>
                <ul>
                    <li><a href="?page=daystar-admin-policy&view=create">Create a new policy manually</a></li>
                    <li><button id="setup-sample-policy" class="button button-primary">Set up sample policy automatically</button></li>
                </ul>
            </div>
        <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Version</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Effective Date</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($policies as $policy): ?>
                    <tr>
                        <td><strong><?php echo esc_html($policy->version_number); ?></strong></td>
                        <td><?php echo esc_html($policy->title); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo esc_attr($policy->status); ?>">
                                <?php echo esc_html(ucfirst($policy->status)); ?>
                            </span>
                        </td>
                        <td><?php echo date('M j, Y', strtotime($policy->effective_date)); ?></td>
                        <td><?php echo esc_html($policy->created_by_name); ?></td>
                        <td><?php echo date('M j, Y g:i A', strtotime($policy->created_at)); ?></td>
                        <td>
                            <div class="policy-actions">
                                <a href="?page=daystar-admin-policy&view=edit&policy_id=<?php echo $policy->id; ?>" 
                                   class="button button-small">Edit</a>
                                
                                <?php if ($policy->status === 'draft'): ?>
                                    <button class="button button-primary button-small publish-policy" 
                                            data-policy-id="<?php echo $policy->id; ?>">Publish</button>
                                <?php endif; ?>
                                
                                <?php if ($policy->status === 'published'): ?>
                                    <button class="button button-secondary button-small archive-policy" 
                                            data-policy-id="<?php echo $policy->id; ?>">Archive</button>
                                <?php endif; ?>
                                
                                <button class="button button-small generate-pdf" 
                                        data-policy-id="<?php echo $policy->id; ?>">Generate PDF</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Display create policy tab
 */
function display_create_policy_tab() {
    ?>
    <div class="policy-card">
        <div class="policy-header">
            <h3>Create New Policy Version</h3>
        </div>
        
        <form id="create-policy-form" class="policy-form">
            <div class="form-row">
                <div>
                    <label for="policy_title">Policy Title</label>
                    <input type="text" id="policy_title" class="regular-text" 
                           value="Daystar SACCO Credit Policy" required>
                </div>
                <div>
                    <label for="version_number">Version Number</label>
                    <input type="text" id="version_number" class="regular-text" 
                           placeholder="e.g., 1.0, 2.1" required>
                </div>
                <div>
                    <label for="effective_date">Effective Date</label>
                    <input type="datetime-local" id="effective_date" class="regular-text" 
                           value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                </div>
            </div>
            
            <div>
                <label for="policy_content">Policy Content</label>
                <textarea id="policy_content" class="policy-editor" required 
                          placeholder="Enter the complete policy content here..."></textarea>
            </div>
            
            <button type="submit" class="button button-primary">Create Policy Version</button>
        </form>
    </div>
    <?php
}

/**
 * Display edit policy tab
 */
function display_edit_policy_tab($policy_id) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'daystar_policy_versions';
    $policy = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE id = %d",
        $policy_id
    ));
    
    if (!$policy) {
        echo '<div class="notice notice-error"><p>Policy version not found.</p></div>';
        return;
    }
    
    ?>
    <div class="policy-card">
        <div class="policy-header">
            <h3>Edit Policy Version <?php echo esc_html($policy->version_number); ?></h3>
            <a href="?page=daystar-admin-policy&view=policies" class="button">← Back to List</a>
        </div>
        
        <?php if ($policy->status === 'published'): ?>
            <div class="notice notice-warning">
                <p><strong>Note:</strong> This policy version is published and cannot be edited. 
                   Create a new version if changes are needed.</p>
            </div>
        <?php else: ?>
            <form id="update-policy-form" class="policy-form">
                <input type="hidden" id="policy_id" value="<?php echo $policy->id; ?>">
                
                <div class="form-row">
                    <div>
                        <label for="policy_title">Policy Title</label>
                        <input type="text" id="policy_title" class="regular-text" 
                               value="<?php echo esc_attr($policy->title); ?>" required>
                    </div>
                    <div>
                        <label for="version_number">Version Number</label>
                        <input type="text" id="version_number" class="regular-text" 
                               value="<?php echo esc_attr($policy->version_number); ?>" readonly>
                    </div>
                    <div>
                        <label for="effective_date">Effective Date</label>
                        <input type="datetime-local" id="effective_date" class="regular-text" 
                               value="<?php echo date('Y-m-d\TH:i', strtotime($policy->effective_date)); ?>" required>
                    </div>
                </div>
                
                <div>
                    <label for="policy_content">Policy Content</label>
                    <textarea id="policy_content" class="policy-editor" required><?php echo esc_textarea($policy->content); ?></textarea>
                </div>
                
                <button type="submit" class="button button-primary">Update Policy Version</button>
            </form>
        <?php endif; ?>
        
        <div class="policy-actions">
            <?php if ($policy->status === 'draft'): ?>
                <button class="button button-primary publish-policy" 
                        data-policy-id="<?php echo $policy->id; ?>">Publish Version</button>
            <?php endif; ?>
            
            <?php if ($policy->status === 'published'): ?>
                <button class="button button-secondary archive-policy" 
                        data-policy-id="<?php echo $policy->id; ?>">Archive Version</button>
            <?php endif; ?>
            
            <button class="button generate-pdf" 
                    data-policy-id="<?php echo $policy->id; ?>">Generate PDF</button>
        </div>
    </div>
    <?php
}

/**
 * Display compare versions tab
 */
function display_compare_versions_tab() {
    $policies = get_policy_versions();
    
    ?>
    <div class="policy-card">
        <div class="policy-header">
            <h3>Compare Policy Versions</h3>
        </div>
        
        <?php if (count($policies) < 2): ?>
            <p>At least two policy versions are required for comparison.</p>
        <?php else: ?>
            <form id="compare-versions-form" class="policy-form">
                <div class="form-row">
                    <div>
                        <label for="version1_select">First Version</label>
                        <select id="version1_select" class="regular-text" required>
                            <option value="">Select Version</option>
                            <?php foreach ($policies as $policy): ?>
                                <option value="<?php echo $policy->id; ?>">
                                    Version <?php echo esc_html($policy->version_number); ?> 
                                    (<?php echo esc_html($policy->status); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="version2_select">Second Version</label>
                        <select id="version2_select" class="regular-text" required>
                            <option value="">Select Version</option>
                            <?php foreach ($policies as $policy): ?>
                                <option value="<?php echo $policy->id; ?>">
                                    Version <?php echo esc_html($policy->version_number); ?> 
                                    (<?php echo esc_html($policy->status); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="button button-primary">Compare Versions</button>
            </form>
            
            <div id="comparison-results"></div>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Display audit trail tab
 */
function display_audit_trail_tab() {
    global $wpdb;
    
    $audit_table = $wpdb->prefix . 'daystar_policy_audit_log';
    $policies_table = $wpdb->prefix . 'daystar_policy_versions';
    
    $audit_logs = $wpdb->get_results("
        SELECT al.*, pv.version_number, u.display_name as user_name
        FROM $audit_table al
        LEFT JOIN $policies_table pv ON al.policy_id = pv.id
        LEFT JOIN {$wpdb->users} u ON al.user_id = u.ID
        ORDER BY al.created_at DESC
        LIMIT 50
    ");
    
    ?>
    <div class="policy-card">
        <div class="policy-header">
            <h3>Policy Audit Trail</h3>
        </div>
        
        <?php if (empty($audit_logs)): ?>
            <p>No audit trail entries found.</p>
        <?php else: ?>
            <?php foreach ($audit_logs as $log): ?>
                <div class="audit-entry">
                    <div class="audit-header">
                        <span>
                            <strong><?php echo esc_html(ucfirst($log->action)); ?></strong>
                            - Version <?php echo esc_html($log->version_number); ?>
                        </span>
                        <span><?php echo date('M j, Y g:i A', strtotime($log->created_at)); ?></span>
                    </div>
                    <div class="audit-details">
                        <p><strong>User:</strong> <?php echo esc_html($log->user_name); ?></p>
                        <p><strong>Description:</strong> <?php echo esc_html($log->description); ?></p>
                        <p><strong>IP Address:</strong> <?php echo esc_html($log->ip_address); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php
}