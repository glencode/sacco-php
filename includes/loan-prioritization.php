<?php
/**
 * Loan Prioritization System
 * Implements PRD Section 4.2 - Loan Prioritization Mechanism
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Loan Prioritization Settings Page
 */
function daystar_loan_prioritization_settings() {
    // Handle form submissions
    if (isset($_POST['action']) && $_POST['action'] === 'update_prioritization_settings') {
        daystar_update_prioritization_settings();
    }
    
    $settings = daystar_get_prioritization_settings();
    
    ?>
    <div class="wrap">
        <h1>Loan Prioritization Settings</h1>
        
        <?php if (isset($_GET['message'])) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($_GET['message']); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="prioritization-settings-container">
            <div class="settings-section">
                <h2>Prioritization Factors & Weights</h2>
                <p>Configure the weights for different factors that determine loan application priority. Higher weights give more importance to that factor.</p>
                
                <form method="post" action="">
                    <input type="hidden" name="action" value="update_prioritization_settings">
                    <?php wp_nonce_field('update_prioritization_settings', 'prioritization_nonce'); ?>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="emergency_weight">Emergency Loans</label>
                                <p class="description">Medical emergencies, urgent repairs, etc.</p>
                            </th>
                            <td>
                                <input type="number" id="emergency_weight" name="emergency_weight" 
                                       value="<?php echo esc_attr($settings['emergency_weight']); ?>" 
                                       min="0" max="50" step="1" class="small-text">
                                <span class="description">points (0-50)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="school_fees_weight">School Fees Loans</label>
                                <p class="description">Education-related loan applications</p>
                            </th>
                            <td>
                                <input type="number" id="school_fees_weight" name="school_fees_weight" 
                                       value="<?php echo esc_attr($settings['school_fees_weight']); ?>" 
                                       min="0" max="30" step="1" class="small-text">
                                <span class="description">points (0-30)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="development_weight">Development Loans</label>
                                <p class="description">Business development, asset acquisition</p>
                            </th>
                            <td>
                                <input type="number" id="development_weight" name="development_weight" 
                                       value="<?php echo esc_attr($settings['development_weight']); ?>" 
                                       min="0" max="25" step="1" class="small-text">
                                <span class="description">points (0-25)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="new_member_weight">New Members</label>
                                <p class="description">Members who joined within the last 12 months</p>
                            </th>
                            <td>
                                <input type="number" id="new_member_weight" name="new_member_weight" 
                                       value="<?php echo esc_attr($settings['new_member_weight']); ?>" 
                                       min="0" max="20" step="1" class="small-text">
                                <span class="description">points (0-20)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="first_time_borrower_weight">First-Time Borrowers</label>
                                <p class="description">Members who have never taken a loan</p>
                            </th>
                            <td>
                                <input type="number" id="first_time_borrower_weight" name="first_time_borrower_weight" 
                                       value="<?php echo esc_attr($settings['first_time_borrower_weight']); ?>" 
                                       min="0" max="25" step="1" class="small-text">
                                <span class="description">points (0-25)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="good_repayment_weight">Good Repayment History</label>
                                <p class="description">Members who have cleared previous loans successfully</p>
                            </th>
                            <td>
                                <input type="number" id="good_repayment_weight" name="good_repayment_weight" 
                                       value="<?php echo esc_attr($settings['good_repayment_weight']); ?>" 
                                       min="0" max="15" step="1" class="small-text">
                                <span class="description">points (0-15)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="application_age_weight">Application Age</label>
                                <p class="description">Older applications get higher priority</p>
                            </th>
                            <td>
                                <input type="number" id="application_age_weight" name="application_age_weight" 
                                       value="<?php echo esc_attr($settings['application_age_weight']); ?>" 
                                       min="0" max="20" step="1" class="small-text">
                                <span class="description">points (0-20)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="small_loan_weight">Small Loan Amounts</label>
                                <p class="description">Loans under KES 50,000 for quick processing</p>
                            </th>
                            <td>
                                <input type="number" id="small_loan_weight" name="small_loan_weight" 
                                       value="<?php echo esc_attr($settings['small_loan_weight']); ?>" 
                                       min="0" max="10" step="1" class="small-text">
                                <span class="description">points (0-10)</span>
                            </td>
                        </tr>
                    </table>
                    
                    <h3>Priority Thresholds</h3>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="high_priority_threshold">High Priority Threshold</label>
                                <p class="description">Minimum score for high priority classification</p>
                            </th>
                            <td>
                                <input type="number" id="high_priority_threshold" name="high_priority_threshold" 
                                       value="<?php echo esc_attr($settings['high_priority_threshold']); ?>" 
                                       min="70" max="100" step="1" class="small-text">
                                <span class="description">points (70-100)</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="medium_priority_threshold">Medium Priority Threshold</label>
                                <p class="description">Minimum score for medium priority classification</p>
                            </th>
                            <td>
                                <input type="number" id="medium_priority_threshold" name="medium_priority_threshold" 
                                       value="<?php echo esc_attr($settings['medium_priority_threshold']); ?>" 
                                       min="50" max="80" step="1" class="small-text">
                                <span class="description">points (50-80)</span>
                            </td>
                        </tr>
                    </table>
                    
                    <h3>Fund Allocation Settings</h3>
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="enable_fund_allocation">Enable Automatic Fund Allocation</label>
                                <p class="description">Automatically allocate available funds based on priority</p>
                            </th>
                            <td>
                                <label>
                                    <input type="checkbox" id="enable_fund_allocation" name="enable_fund_allocation" 
                                           value="1" <?php checked($settings['enable_fund_allocation'], 1); ?>>
                                    Enable automatic fund allocation
                                </label>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="high_priority_allocation">High Priority Allocation</label>
                                <p class="description">Percentage of available funds reserved for high priority loans</p>
                            </th>
                            <td>
                                <input type="number" id="high_priority_allocation" name="high_priority_allocation" 
                                       value="<?php echo esc_attr($settings['high_priority_allocation']); ?>" 
                                       min="0" max="100" step="5" class="small-text">
                                <span class="description">% of available funds</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="medium_priority_allocation">Medium Priority Allocation</label>
                                <p class="description">Percentage of available funds reserved for medium priority loans</p>
                            </th>
                            <td>
                                <input type="number" id="medium_priority_allocation" name="medium_priority_allocation" 
                                       value="<?php echo esc_attr($settings['medium_priority_allocation']); ?>" 
                                       min="0" max="100" step="5" class="small-text">
                                <span class="description">% of available funds</span>
                            </td>
                        </tr>
                    </table>
                    
                    <?php submit_button('Update Prioritization Settings'); ?>
                </form>
            </div>
            
            <div class="settings-section">
                <h2>Priority Calculation Preview</h2>
                <p>This shows how the current settings would affect loan prioritization:</p>
                
                <div class="priority-examples">
                    <div class="example-card">
                        <h4>Emergency Loan Example</h4>
                        <ul>
                            <li>Emergency loan: +<?php echo $settings['emergency_weight']; ?> points</li>
                            <li>New member: +<?php echo $settings['new_member_weight']; ?> points</li>
                            <li>First-time borrower: +<?php echo $settings['first_time_borrower_weight']; ?> points</li>
                            <li>Base score: +50 points</li>
                        </ul>
                        <strong>Total: <?php echo 50 + $settings['emergency_weight'] + $settings['new_member_weight'] + $settings['first_time_borrower_weight']; ?> points</strong>
                        <br><em>Priority: HIGH</em>
                    </div>
                    
                    <div class="example-card">
                        <h4>Development Loan Example</h4>
                        <ul>
                            <li>Development loan: +<?php echo $settings['development_weight']; ?> points</li>
                            <li>Good repayment history: +<?php echo $settings['good_repayment_weight']; ?> points</li>
                            <li>Application pending 10 days: +<?php echo $settings['application_age_weight']; ?> points</li>
                            <li>Base score: +50 points</li>
                        </ul>
                        <strong>Total: <?php echo 50 + $settings['development_weight'] + $settings['good_repayment_weight'] + $settings['application_age_weight']; ?> points</strong>
                        <br><em>Priority: <?php 
                        $example_score = 50 + $settings['development_weight'] + $settings['good_repayment_weight'] + $settings['application_age_weight'];
                        if ($example_score >= $settings['high_priority_threshold']) echo 'HIGH';
                        elseif ($example_score >= $settings['medium_priority_threshold']) echo 'MEDIUM';
                        else echo 'LOW';
                        ?></em>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .prioritization-settings-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-top: 20px;
    }
    
    .settings-section {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .settings-section h2 {
        margin-top: 0;
        color: #1d4ed8;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 10px;
    }
    
    .priority-examples {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .example-card {
        background: #f9fafb;
        padding: 15px;
        border-radius: 6px;
        border-left: 4px solid #1d4ed8;
    }
    
    .example-card h4 {
        margin: 0 0 10px 0;
        color: #374151;
    }
    
    .example-card ul {
        margin: 10px 0;
        padding-left: 20px;
    }
    
    .example-card li {
        margin-bottom: 5px;
        color: #6b7280;
    }
    
    @media (max-width: 1200px) {
        .prioritization-settings-container {
            grid-template-columns: 1fr;
        }
    }
    </style>
    <?php
}

/**
 * Decision Templates Page
 */
function daystar_decision_templates_page() {
    // Handle form submissions
    if (isset($_POST['action'])) {
        daystar_handle_decision_template_action();
    }
    
    $templates = daystar_get_decision_templates();
    
    ?>
    <div class="wrap">
        <h1>Loan Decision Templates</h1>
        
        <?php if (isset($_GET['message'])) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($_GET['message']); ?></p>
            </div>
        <?php endif; ?>
        
        <div class="decision-templates-container">
            <div class="templates-section">
                <h2>Rejection Reason Templates</h2>
                <p>Pre-defined templates for common loan rejection reasons to ensure consistent communication.</p>
                
                <div class="template-cards">
                    <?php foreach ($templates['rejection'] as $key => $template) : ?>
                        <div class="template-card">
                            <h4><?php echo esc_html($template['title']); ?></h4>
                            <p class="template-content"><?php echo esc_html($template['content']); ?></p>
                            <div class="template-actions">
                                <button type="button" class="button button-small" onclick="editTemplate('rejection', '<?php echo $key; ?>')">Edit</button>
                                <button type="button" class="button button-small" onclick="useTemplate('<?php echo esc_js($template['content']); ?>')">Use Template</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <h2>Approval Condition Templates</h2>
                <p>Templates for special conditions that may be attached to loan approvals.</p>
                
                <div class="template-cards">
                    <?php foreach ($templates['approval'] as $key => $template) : ?>
                        <div class="template-card">
                            <h4><?php echo esc_html($template['title']); ?></h4>
                            <p class="template-content"><?php echo esc_html($template['content']); ?></p>
                            <div class="template-actions">
                                <button type="button" class="button button-small" onclick="editTemplate('approval', '<?php echo $key; ?>')">Edit</button>
                                <button type="button" class="button button-small" onclick="useTemplate('<?php echo esc_js($template['content']); ?>')">Use Template</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <h2>Information Request Templates</h2>
                <p>Templates for requesting additional information from loan applicants.</p>
                
                <div class="template-cards">
                    <?php foreach ($templates['info_request'] as $key => $template) : ?>
                        <div class="template-card">
                            <h4><?php echo esc_html($template['title']); ?></h4>
                            <p class="template-content"><?php echo esc_html($template['content']); ?></p>
                            <div class="template-actions">
                                <button type="button" class="button button-small" onclick="editTemplate('info_request', '<?php echo $key; ?>')">Edit</button>
                                <button type="button" class="button button-small" onclick="useTemplate('<?php echo esc_js($template['content']); ?>')">Use Template</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="add-template-section">
                <h2>Add New Template</h2>
                
                <form method="post" action="">
                    <input type="hidden" name="action" value="add_decision_template">
                    <?php wp_nonce_field('add_decision_template', 'template_nonce'); ?>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row">
                                <label for="template_type">Template Type</label>
                            </th>
                            <td>
                                <select id="template_type" name="template_type" required>
                                    <option value="">Select type...</option>
                                    <option value="rejection">Rejection Reason</option>
                                    <option value="approval">Approval Condition</option>
                                    <option value="info_request">Information Request</option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="template_title">Template Title</label>
                            </th>
                            <td>
                                <input type="text" id="template_title" name="template_title" 
                                       class="regular-text" required 
                                       placeholder="e.g., Insufficient Share Capital">
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">
                                <label for="template_content">Template Content</label>
                            </th>
                            <td>
                                <textarea id="template_content" name="template_content" 
                                          rows="5" cols="50" class="large-text" required
                                          placeholder="Enter the template message content..."></textarea>
                                <p class="description">Use placeholders like {member_name}, {loan_amount}, {loan_type} for dynamic content.</p>
                            </td>
                        </tr>
                    </table>
                    
                    <?php submit_button('Add Template'); ?>
                </form>
            </div>
        </div>
    </div>
    
    <style>
    .decision-templates-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-top: 20px;
    }
    
    .templates-section,
    .add-template-section {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .templates-section h2,
    .add-template-section h2 {
        margin-top: 0;
        color: #1d4ed8;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 10px;
    }
    
    .template-cards {
        display: grid;
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .template-card {
        background: #f9fafb;
        padding: 15px;
        border-radius: 6px;
        border-left: 4px solid #1d4ed8;
    }
    
    .template-card h4 {
        margin: 0 0 10px 0;
        color: #374151;
    }
    
    .template-content {
        color: #6b7280;
        font-style: italic;
        margin: 10px 0;
        line-height: 1.5;
    }
    
    .template-actions {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    
    @media (max-width: 1200px) {
        .decision-templates-container {
            grid-template-columns: 1fr;
        }
    }
    </style>
    
    <script>
    function editTemplate(type, key) {
        alert('Edit template functionality - to be implemented');
    }
    
    function useTemplate(content) {
        // Copy template content to clipboard
        navigator.clipboard.writeText(content).then(function() {
            alert('Template copied to clipboard!');
        });
    }
    </script>
    <?php
}

/**
 * Get default prioritization settings
 */
function daystar_get_prioritization_settings() {
    $defaults = array(
        'emergency_weight' => 30,
        'school_fees_weight' => 20,
        'development_weight' => 15,
        'new_member_weight' => 15,
        'first_time_borrower_weight' => 20,
        'good_repayment_weight' => 10,
        'application_age_weight' => 15,
        'small_loan_weight' => 5,
        'high_priority_threshold' => 80,
        'medium_priority_threshold' => 65,
        'enable_fund_allocation' => 1,
        'high_priority_allocation' => 60,
        'medium_priority_allocation' => 30
    );
    
    $settings = get_option('daystar_prioritization_settings', $defaults);
    
    // Ensure all defaults are present
    return array_merge($defaults, $settings);
}

/**
 * Update prioritization settings
 */
function daystar_update_prioritization_settings() {
    if (!wp_verify_nonce($_POST['prioritization_nonce'], 'update_prioritization_settings')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    $settings = array(
        'emergency_weight' => intval($_POST['emergency_weight']),
        'school_fees_weight' => intval($_POST['school_fees_weight']),
        'development_weight' => intval($_POST['development_weight']),
        'new_member_weight' => intval($_POST['new_member_weight']),
        'first_time_borrower_weight' => intval($_POST['first_time_borrower_weight']),
        'good_repayment_weight' => intval($_POST['good_repayment_weight']),
        'application_age_weight' => intval($_POST['application_age_weight']),
        'small_loan_weight' => intval($_POST['small_loan_weight']),
        'high_priority_threshold' => intval($_POST['high_priority_threshold']),
        'medium_priority_threshold' => intval($_POST['medium_priority_threshold']),
        'enable_fund_allocation' => isset($_POST['enable_fund_allocation']) ? 1 : 0,
        'high_priority_allocation' => intval($_POST['high_priority_allocation']),
        'medium_priority_allocation' => intval($_POST['medium_priority_allocation'])
    );
    
    update_option('daystar_prioritization_settings', $settings);
    
    wp_redirect(admin_url('admin.php?page=daystar-loan-prioritization&message=' . urlencode('Settings updated successfully.')));
    exit;
}

/**
 * Get decision templates
 */
function daystar_get_decision_templates() {
    $defaults = array(
        'rejection' => array(
            'insufficient_share_capital' => array(
                'title' => 'Insufficient Share Capital',
                'content' => 'Your loan application has been declined due to insufficient share capital. You need a minimum of KES 5,000 in share capital to qualify for a loan. Please increase your share capital and reapply.'
            ),
            'inconsistent_contributions' => array(
                'title' => 'Inconsistent Contributions',
                'content' => 'Your loan application has been declined due to inconsistent monthly contributions. Please maintain regular contributions of at least KES 2,000 per month for 6 consecutive months before reapplying.'
            ),
            'poor_credit_history' => array(
                'title' => 'Poor Credit History',
                'content' => 'Your loan application has been declined due to poor credit history. Please clear any outstanding obligations and maintain good payment behavior before reapplying.'
            ),
            'insufficient_income' => array(
                'title' => 'Insufficient Income',
                'content' => 'Your loan application has been declined as your verified income is insufficient to support the requested loan amount. Please provide updated income documentation or apply for a smaller amount.'
            ),
            'inadequate_guarantors' => array(
                'title' => 'Inadequate Guarantors',
                'content' => 'Your loan application has been declined due to inadequate guarantors. Please provide two valid guarantors who are active SACCO members with sufficient guaranteeing capacity.'
            )
        ),
        'approval' => array(
            'standard_approval' => array(
                'title' => 'Standard Approval',
                'content' => 'Your loan has been approved subject to standard terms and conditions. Please ensure timely monthly payments as per the agreed schedule.'
            ),
            'reduced_amount' => array(
                'title' => 'Approved with Reduced Amount',
                'content' => 'Your loan has been approved for a reduced amount of {approved_amount} based on your current eligibility. You may reapply for a higher amount after improving your eligibility criteria.'
            ),
            'additional_guarantor' => array(
                'title' => 'Approved with Additional Guarantor Required',
                'content' => 'Your loan has been approved subject to providing an additional guarantor. Please provide the required guarantor information before disbursement.'
            )
        ),
        'info_request' => array(
            'updated_payslip' => array(
                'title' => 'Updated Payslip Required',
                'content' => 'Please provide your most recent payslip (not older than 3 months) to complete the processing of your loan application.'
            ),
            'guarantor_details' => array(
                'title' => 'Guarantor Details Required',
                'content' => 'Please provide complete details of your proposed guarantors including their member numbers, contact information, and signed guarantee forms.'
            ),
            'collateral_documentation' => array(
                'title' => 'Collateral Documentation Required',
                'content' => 'Please provide proper documentation for the proposed collateral including valuation reports, ownership documents, and insurance details.'
            )
        )
    );
    
    $templates = get_option('daystar_decision_templates', $defaults);
    
    // Ensure all defaults are present
    return array_merge_recursive($defaults, $templates);
}

/**
 * Handle decision template actions
 */
function daystar_handle_decision_template_action() {
    $action = sanitize_text_field($_POST['action']);
    
    switch ($action) {
        case 'add_decision_template':
            daystar_add_decision_template();
            break;
    }
}

/**
 * Add new decision template
 */
function daystar_add_decision_template() {
    if (!wp_verify_nonce($_POST['template_nonce'], 'add_decision_template')) {
        wp_die('Security check failed');
    }
    
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
    
    $type = sanitize_text_field($_POST['template_type']);
    $title = sanitize_text_field($_POST['template_title']);
    $content = sanitize_textarea_field($_POST['template_content']);
    
    $templates = daystar_get_decision_templates();
    
    $key = sanitize_key(str_replace(' ', '_', strtolower($title)));
    
    $templates[$type][$key] = array(
        'title' => $title,
        'content' => $content
    );
    
    update_option('daystar_decision_templates', $templates);
    
    wp_redirect(admin_url('admin.php?page=daystar-decision-templates&message=' . urlencode('Template added successfully.')));
    exit;
}

/**
 * Calculate fund allocation based on priority
 */
function daystar_calculate_fund_allocation($available_funds) {
    $settings = daystar_get_prioritization_settings();
    
    if (!$settings['enable_fund_allocation']) {
        return array(
            'high_priority' => $available_funds,
            'medium_priority' => $available_funds,
            'low_priority' => $available_funds
        );
    }
    
    $high_allocation = ($available_funds * $settings['high_priority_allocation']) / 100;
    $medium_allocation = ($available_funds * $settings['medium_priority_allocation']) / 100;
    $low_allocation = $available_funds - $high_allocation - $medium_allocation;
    
    return array(
        'high_priority' => $high_allocation,
        'medium_priority' => $medium_allocation,
        'low_priority' => max(0, $low_allocation)
    );
}

/**
 * Get prioritized loan applications for fund allocation
 */
function daystar_get_prioritized_applications_for_funding($available_funds) {
    $applications = daystar_get_credit_committee_applications('approved');
    $fund_allocation = daystar_calculate_fund_allocation($available_funds);
    
    $prioritized = array(
        'high_priority' => array(),
        'medium_priority' => array(),
        'low_priority' => array()
    );
    
    foreach ($applications as $application) {
        $priority_data = daystar_calculate_loan_priority($application);
        $prioritized[$priority_data['level'] . '_priority'][] = $application;
    }
    
    // Sort each priority group by score (highest first)
    foreach ($prioritized as $priority => &$apps) {
        usort($apps, function($a, $b) {
            $priority_a = daystar_calculate_loan_priority($a);
            $priority_b = daystar_calculate_loan_priority($b);
            return $priority_b['score'] - $priority_a['score'];
        });
    }
    
    return array(
        'applications' => $prioritized,
        'fund_allocation' => $fund_allocation
    );
}