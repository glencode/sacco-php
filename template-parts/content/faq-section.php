<?php
/**
 * Template part for displaying a FAQ section
 *
 * @package sacco-php
 */

// Check if FAQs exist (expects an array of arrays with 'question' and 'answer' keys)
// If not provided directly, try to get from post meta
$faqs = isset($args['faqs']) ? $args['faqs'] : get_post_meta(get_the_ID(), 'faqs', true);

// If still no FAQs and this is a product or loan or savings post type, use default FAQs
if (empty($faqs) && (is_singular('product') || is_singular('loan') || is_singular('savings'))) {
    // Default FAQs based on post type
    if (is_singular('loan')) {
        $faqs = array(
            array(
                'question' => 'What are the eligibility requirements for this loan?',
                'answer' => 'Eligibility typically includes being an active member of the SACCO for at least 3-6 months, having regular contributions, and sufficient shares as collateral. Specific requirements may vary based on loan type.'
            ),
            array(
                'question' => 'How long does the loan application process take?',
                'answer' => 'The standard processing time is 2-3 business days from submission of a complete application with all required documentation. Emergency loans may be processed within 24 hours.'
            ),
            array(
                'question' => 'What documents do I need to apply?',
                'answer' => 'Required documents typically include a completed loan application form, copies of recent pay slips, identification (ID/passport), and guarantor information. Additional documentation may be required based on loan type and amount.'
            ),
            array(
                'question' => 'Can I pay off my loan early?',
                'answer' => 'Yes, you can make early repayments or fully settle your loan before the end of the term. We encourage early repayment and do not charge early repayment penalties.'
            ),
            array(
                'question' => 'How is the interest calculated?',
                'answer' => 'Interest is calculated on a reducing balance method, which means you only pay interest on the outstanding loan amount. As you pay down your loan, your interest payments decrease over time.'
            )
        );
    } elseif (is_singular('savings')) {
        $faqs = array(
            array(
                'question' => 'How do I open this savings account?',
                'answer' => 'To open a savings account, complete the account opening form available online or at any branch, provide required identification documents, and make your initial deposit. The account will typically be active within 1-2 business days.'
            ),
            array(
                'question' => 'Is there a minimum balance requirement?',
                'answer' => 'Yes, most savings accounts require a minimum balance to be maintained. The specific amount varies by account type and is designed to encourage consistent saving habits.'
            ),
            array(
                'question' => 'How is interest calculated and paid?',
                'answer' => 'Interest is calculated on daily balance and paid monthly, quarterly, or annually depending on the account type. The current interest rate is displayed on the product page and is subject to review by the SACCO board.'
            ),
            array(
                'question' => 'Can I make withdrawals from this account?',
                'answer' => 'Withdrawal policies vary by account type. Regular savings accounts allow immediate access, while fixed deposit accounts may have restrictions or penalties for early withdrawal before maturity.'
            ),
            array(
                'question' => 'Are there any fees associated with this account?',
                'answer' => 'Most savings accounts have minimal to no monthly maintenance fees. However, there may be fees for services like statements, below-minimum balance, or excessive withdrawals. Refer to our fee schedule for details.'
            )
        );
    } elseif (is_singular('product')) {
        $faqs = array(
            array(
                'question' => 'How do I qualify for this product?',
                'answer' => 'Qualification requirements vary by product but generally include membership status, minimum share capital, and account activity. Specific products may have additional requirements based on their nature.'
            ),
            array(
                'question' => 'What are the main benefits of this product?',
                'answer' => 'Our products are designed with competitive rates, flexible terms, and member-friendly policies. Each product offers unique benefits tailored to different financial needs and goals.'
            ),
            array(
                'question' => 'How can I apply for this product?',
                'answer' => 'Applications can be submitted online through our member portal, in person at any branch, or via our mobile app. Our customer service team can guide you through the application process.'
            ),
            array(
                'question' => 'Are there any associated fees?',
                'answer' => 'Fee structures vary by product. We pride ourselves on transparent pricing with no hidden fees. All applicable fees are clearly outlined in our product disclosure documents and fee schedule.'
            ),
            array(
                'question' => 'How long does processing take?',
                'answer' => 'Processing times vary depending on the product. Most applications are processed within 1-3 business days once all required documentation is received.'
            )
        );
    }
}

// If we have FAQs, display them
if (!empty($faqs) && is_array($faqs)) :
    $accordion_id = 'faq-accordion-' . get_the_ID();
?>
<section class="faq-section py-4">
    <div class="section-header mb-4">
        <h2 class="section-title">Frequently Asked Questions</h2>
    </div>
    
    <div class="accordion" id="<?php echo esc_attr($accordion_id); ?>">
        <?php foreach ($faqs as $index => $faq) : 
            $item_id = 'faq-item-' . get_the_ID() . '-' . $index;
            $heading_id = 'faq-heading-' . get_the_ID() . '-' . $index;
            $collapse_id = 'faq-collapse-' . get_the_ID() . '-' . $index;
            $is_first = ($index === 0);
        ?>
            <div class="accordion-item">
                <h3 class="accordion-header" id="<?php echo esc_attr($heading_id); ?>">
                    <button class="accordion-button <?php echo (!$is_first ? 'collapsed' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr($collapse_id); ?>" aria-expanded="<?php echo ($is_first ? 'true' : 'false'); ?>" aria-controls="<?php echo esc_attr($collapse_id); ?>">
                        <?php echo esc_html($faq['question']); ?>
                    </button>
                </h3>
                <div id="<?php echo esc_attr($collapse_id); ?>" class="accordion-collapse collapse <?php echo ($is_first ? 'show' : ''); ?>" aria-labelledby="<?php echo esc_attr($heading_id); ?>" data-bs-parent="#<?php echo esc_attr($accordion_id); ?>">
                    <div class="accordion-body">
                        <?php echo wp_kses_post($faq['answer']); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?> 