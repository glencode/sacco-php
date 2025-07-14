<?php
/**
 * Testimonials Population Script for Daystar SACCO
 * 
 * This script will:
 * 1. Create testimonial categories for different pages/services
 * 2. Populate the testimonials CPT with many Kenyan testimonials
 * 3. Categorize testimonials appropriately for different pages
 * 
 * Run this script once to populate testimonials data
 */

// Prevent direct access - only allow when WordPress is loaded
if (!defined('ABSPATH')) {
    // Try to find wp-config.php in common locations
    $config_paths = array(
        '../../../../wp-config.php',
        '../../../../../wp-config.php',
        '../../../../../../wp-config.php',
        '../../../wp-config.php'
    );
    
    $config_loaded = false;
    foreach ($config_paths as $config_path) {
        if (file_exists($config_path)) {
            require_once($config_path);
            $config_loaded = true;
            break;
        }
    }
    
    if (!$config_loaded) {
        die('Error: This script must be run from WordPress admin or wp-config.php could not be found. Please use the admin interface at Tools > Populate Testimonials instead.');
    }
}

// Register Testimonial Category Taxonomy (if not already exists)
function daystar_register_testimonial_category_taxonomy() {
    if (!taxonomy_exists('testimonial_category')) {
        $labels = array(
            'name'                       => _x('Testimonial Categories', 'Taxonomy General Name', 'sacco-php'),
            'singular_name'              => _x('Testimonial Category', 'Taxonomy Singular Name', 'sacco-php'),
            'menu_name'                  => __('Testimonial Categories', 'sacco-php'),
            'all_items'                  => __('All Testimonial Categories', 'sacco-php'),
            'parent_item'                => __('Parent Testimonial Category', 'sacco-php'),
            'parent_item_colon'          => __('Parent Testimonial Category:', 'sacco-php'),
            'new_item_name'              => __('New Testimonial Category Name', 'sacco-php'),
            'add_new_item'               => __('Add New Testimonial Category', 'sacco-php'),
            'edit_item'                  => __('Edit Testimonial Category', 'sacco-php'),
            'update_item'                => __('Update Testimonial Category', 'sacco-php'),
            'view_item'                  => __('View Testimonial Category', 'sacco-php'),
            'separate_items_with_commas' => __('Separate testimonial categories with commas', 'sacco-php'),
            'add_or_remove_items'        => __('Add or remove testimonial categories', 'sacco-php'),
            'choose_from_most_used'      => __('Choose from the most used', 'sacco-php'),
            'popular_items'              => __('Popular Testimonial Categories', 'sacco-php'),
            'search_items'               => __('Search Testimonial Categories', 'sacco-php'),
            'not_found'                  => __('Not Found', 'sacco-php'),
            'no_terms'                   => __('No testimonial categories', 'sacco-php'),
            'items_list'                 => __('Testimonial Categories list', 'sacco-php'),
            'items_list_navigation'      => __('Testimonial Categories list navigation', 'sacco-php'),
        );
        
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => false,
            'show_in_rest'               => true,
        );
        
        register_taxonomy('testimonial_category', array('testimonial'), $args);
    }
}

// Create testimonial categories
function daystar_create_testimonial_categories() {
    $categories = array(
        'general' => array(
            'name' => 'General',
            'description' => 'General testimonials for homepage and overall SACCO experience'
        ),
        'development-loans' => array(
            'name' => 'Development Loans',
            'description' => 'Testimonials specifically about development loans'
        ),
        'emergency-loans' => array(
            'name' => 'Emergency Loans',
            'description' => 'Testimonials about emergency loan services'
        ),
        'school-fees-loans' => array(
            'name' => 'School Fees Loans',
            'description' => 'Testimonials about school fees loan services'
        ),
        'special-loans' => array(
            'name' => 'Special Loans',
            'description' => 'Testimonials about special loan products'
        ),
        'super-saver-loans' => array(
            'name' => 'Super Saver Loans',
            'description' => 'Testimonials about super saver loan products'
        ),
        'salary-advance' => array(
            'name' => 'Salary Advance',
            'description' => 'Testimonials about salary advance services'
        ),
        'savings-accounts' => array(
            'name' => 'Savings Accounts',
            'description' => 'Testimonials about savings account services'
        ),
        'membership-benefits' => array(
            'name' => 'Membership Benefits',
            'description' => 'Testimonials about overall membership benefits'
        ),
        'products-services' => array(
            'name' => 'Products & Services',
            'description' => 'General testimonials about products and services'
        ),
        'financial-education' => array(
            'name' => 'Financial Education',
            'description' => 'Testimonials about financial education programs'
        )
    );

    foreach ($categories as $slug => $category) {
        if (!term_exists($category['name'], 'testimonial_category')) {
            wp_insert_term(
                $category['name'],
                'testimonial_category',
                array(
                    'description' => $category['description'],
                    'slug' => $slug
                )
            );
        }
    }
}

// Kenyan testimonials data
function daystar_get_kenyan_testimonials() {
    return array(
        // General/Homepage testimonials
        array(
            'name' => 'Dr. Grace Wanjiku',
            'position' => 'Senior Lecturer, School of Business',
            'member_since' => '2018',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'Daystar SACCO has been instrumental in my financial growth. The competitive interest rates and flexible repayment terms have enabled me to invest in property and secure my family\'s future. The staff is professional and always ready to help.',
            'categories' => array('general', 'membership-benefits')
        ),
        array(
            'name' => 'James Mwangi',
            'position' => 'IT Administrator',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The development loan I received helped me build my dream home in Kiambu. The 48-month repayment period for permanent staff made it very manageable. I highly recommend Daystar SACCO to anyone looking for reliable financial services.',
            'categories' => array('general', 'development-loans')
        ),
        array(
            'name' => 'Mary Ochieng',
            'position' => 'Administrative Assistant',
            'member_since' => '2020',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'When I had a medical emergency, Daystar SACCO processed my emergency loan the same day. Their quick response and understanding during my difficult time was truly appreciated. This is what community banking should be.',
            'categories' => array('general', 'emergency-loans')
        ),
        array(
            'name' => 'Prof. David Kiprotich',
            'position' => 'Dean, School of Science',
            'member_since' => '2017',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The school fees loan at 10% interest has been a blessing for my children\'s education. As an academic, I appreciate how the SACCO understands our unique financial needs and provides tailored solutions.',
            'categories' => array('general', 'school-fees-loans')
        ),
        array(
            'name' => 'Sarah Njeri',
            'position' => 'Librarian',
            'member_since' => '2021',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'Joining Daystar SACCO was one of my best financial decisions. The savings account has helped me build an emergency fund, and the dividend payments are always a pleasant surprise at the end of the year.',
            'categories' => array('general', 'savings-accounts')
        ),

        // Development Loans specific
        array(
            'name' => 'Peter Kamau',
            'position' => 'Senior Accountant',
            'member_since' => '2018',
            'member_type' => 'Permanent Staff',
            'rating' => 5,
            'content' => 'The development loan enabled me to purchase land in Machakos and start construction of rental units. The loan officers were helpful throughout the process, and I appreciate the transparent terms and conditions.',
            'categories' => array('development-loans', 'products-services')
        ),
        array(
            'name' => 'Dr. Ruth Wambui',
            'position' => 'Associate Professor',
            'member_since' => '2016',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'I used my development loan to expand my private practice clinic. The competitive interest rates and flexible repayment schedule allowed me to grow my business without straining my finances.',
            'categories' => array('development-loans')
        ),
        array(
            'name' => 'John Otieno',
            'position' => 'Maintenance Supervisor',
            'member_since' => '2019',
            'member_type' => 'Permanent Staff',
            'rating' => 4,
            'content' => 'Building my family home seemed impossible until I discovered Daystar SACCO\'s development loans. The 48-month repayment period for permanent staff made my monthly payments very affordable.',
            'categories' => array('development-loans')
        ),
        array(
            'name' => 'Agnes Mutindi',
            'position' => 'Human Resources Officer',
            'member_since' => '2020',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The development loan helped me start my poultry farming business. Today, my business is thriving and providing additional income for my family. Thank you, Daystar SACCO!',
            'categories' => array('development-loans')
        ),

        // Emergency Loans specific
        array(
            'name' => 'Michael Wekesa',
            'position' => 'Security Supervisor',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'When my wife needed urgent surgery, Daystar SACCO approved my emergency loan within hours. The quick processing and compassionate service during our family crisis was truly remarkable.',
            'categories' => array('emergency-loans')
        ),
        array(
            'name' => 'Catherine Akinyi',
            'position' => 'Student Affairs Officer',
            'member_since' => '2018',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The emergency loan saved my family when our house was damaged by floods. The SACCO understood the urgency and processed everything quickly, allowing us to start repairs immediately.',
            'categories' => array('emergency-loans')
        ),
        array(
            'name' => 'Daniel Kiplagat',
            'position' => 'Grounds Keeper',
            'member_since' => '2020',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'When my father passed away unexpectedly, the emergency loan helped cover funeral expenses. The SACCO staff was very understanding and supportive during this difficult time.',
            'categories' => array('emergency-loans')
        ),

        // School Fees Loans specific
        array(
            'name' => 'Dr. Elizabeth Nyong\'o',
            'position' => 'Head of Department, Psychology',
            'member_since' => '2017',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The school fees loan at 10% interest has enabled me to send my three children to quality private schools. The repayment terms align perfectly with my salary schedule.',
            'categories' => array('school-fees-loans')
        ),
        array(
            'name' => 'Francis Muthomi',
            'position' => 'Laboratory Technician',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'My daughter is now in university thanks to the school fees loan. The affordable interest rate made it possible for me to support her education without compromising our family\'s other needs.',
            'categories' => array('school-fees-loans')
        ),
        array(
            'name' => 'Joyce Wanjala',
            'position' => 'Admissions Officer',
            'member_since' => '2018',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'The school fees loan helped me pay for my son\'s secondary school education at a top national school. The flexible repayment options made it stress-free.',
            'categories' => array('school-fees-loans')
        ),

        // Savings Accounts specific
        array(
            'name' => 'Robert Macharia',
            'position' => 'Finance Officer',
            'member_since' => '2018',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The savings account with competitive interest rates has helped me build a substantial emergency fund. The annual dividends are always a welcome bonus that motivates me to save more.',
            'categories' => array('savings-accounts')
        ),
        array(
            'name' => 'Esther Chebet',
            'position' => 'Student Counselor',
            'member_since' => '2020',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'I love how easy it is to save with Daystar SACCO. The automatic payroll deductions ensure I save consistently, and watching my savings grow has been very motivating.',
            'categories' => array('savings-accounts')
        ),
        array(
            'name' => 'Samuel Kiprotich',
            'position' => 'Transport Coordinator',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The savings account helped me accumulate enough money to start my own transport business. The competitive interest rates made my money work harder for me.',
            'categories' => array('savings-accounts')
        ),

        // Special Loans specific
        array(
            'name' => 'Dr. Margaret Wanjiru',
            'position' => 'Research Coordinator',
            'member_since' => '2017',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The special loan for conference attendance allowed me to present my research at an international conference in South Africa. This exposure has significantly advanced my academic career.',
            'categories' => array('special-loans')
        ),
        array(
            'name' => 'Paul Mbugua',
            'position' => 'ICT Support Specialist',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'I used the special loan to purchase professional equipment for my photography side business. The flexible terms allowed me to invest in quality equipment that has increased my income.',
            'categories' => array('special-loans')
        ),

        // Super Saver Loans specific
        array(
            'name' => 'Alice Mwende',
            'position' => 'Procurement Officer',
            'member_since' => '2020',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The super saver loan helped me purchase household items and furniture for my new home. The competitive rates and the fact that it\'s secured by my savings made it very attractive.',
            'categories' => array('super-saver-loans')
        ),
        array(
            'name' => 'George Omondi',
            'position' => 'Sports Coordinator',
            'member_since' => '2018',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'I used the super saver loan to buy a motorcycle for my delivery business. The loan was processed quickly, and the repayment terms were very reasonable.',
            'categories' => array('super-saver-loans')
        ),

        // Salary Advance specific
        array(
            'name' => 'Nancy Waweru',
            'position' => 'Academic Registrar Assistant',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The salary advance facility has been a lifesaver during months when unexpected expenses arise. It\'s convenient and helps me manage cash flow without stress.',
            'categories' => array('salary-advance')
        ),
        array(
            'name' => 'Joseph Mutua',
            'position' => 'Facilities Manager',
            'member_since' => '2018',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'When my car broke down unexpectedly, the salary advance helped me cover the repair costs immediately. The quick processing saved me from transportation challenges.',
            'categories' => array('salary-advance')
        ),

        // Financial Education specific
        array(
            'name' => 'Dr. Susan Kariuki',
            'position' => 'Economics Lecturer',
            'member_since' => '2017',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The financial literacy workshops organized by Daystar SACCO have been invaluable. They\'ve helped me make better investment decisions and plan for retirement more effectively.',
            'categories' => array('financial-education')
        ),
        array(
            'name' => 'Patrick Njoroge',
            'position' => 'Maintenance Technician',
            'member_since' => '2020',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'The budgeting workshop I attended changed how I manage my finances. I now save more consistently and have better control over my expenses.',
            'categories' => array('financial-education')
        ),

        // Additional diverse testimonials
        array(
            'name' => 'Dr. Moses Kinyua',
            'position' => 'Vice Chancellor\'s Office',
            'member_since' => '2015',
            'member_type' => 'Senior Staff',
            'rating' => 5,
            'content' => 'As one of the founding members, I\'ve watched Daystar SACCO grow into a reliable financial institution. The personalized service and competitive products make it the best choice for the Daystar community.',
            'categories' => array('general', 'membership-benefits')
        ),
        array(
            'name' => 'Priscilla Wanjiku',
            'position' => 'Student Records Officer',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'The mobile banking services have made it so convenient to check my account balance and make transactions. The technology integration shows how forward-thinking the SACCO is.',
            'categories' => array('general', 'products-services')
        ),
        array(
            'name' => 'Dr. Anthony Gitonga',
            'position' => 'Research Director',
            'member_since' => '2016',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The investment opportunities offered through the SACCO have helped diversify my portfolio. The professional advice from the investment committee has been particularly valuable.',
            'categories' => array('general', 'products-services')
        ),
        array(
            'name' => 'Lucy Muthoni',
            'position' => 'Catering Supervisor',
            'member_since' => '2018',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The group lending program helped me and my colleagues start a catering business together. The SACCO\'s support for entrepreneurship among members is commendable.',
            'categories' => array('general', 'special-loans')
        ),
        array(
            'name' => 'Dr. Rachel Mwangi',
            'position' => 'Student Affairs Dean',
            'member_since' => '2017',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The insurance products offered through the SACCO partnerships have provided comprehensive coverage for my family. It\'s convenient to have everything under one roof.',
            'categories' => array('general', 'products-services')
        ),
        array(
            'name' => 'Charles Kimani',
            'position' => 'Campus Security Chief',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'The retirement planning seminars have helped me prepare better for my future. The SACCO truly cares about the long-term welfare of its members.',
            'categories' => array('financial-education', 'membership-benefits')
        ),
        array(
            'name' => 'Dr. Beatrice Wanjala',
            'position' => 'International Programs Director',
            'member_since' => '2016',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The foreign exchange services have been helpful for my international travel and research collaborations. The rates are competitive and the service is reliable.',
            'categories' => array('products-services')
        ),
        array(
            'name' => 'Stephen Mutiso',
            'position' => 'Grounds Maintenance',
            'member_since' => '2020',
            'member_type' => 'Staff Member',
            'rating' => 4,
            'content' => 'Even as a junior staff member, I feel valued at Daystar SACCO. The same quality service is provided to all members regardless of their position or salary level.',
            'categories' => array('general', 'membership-benefits')
        ),
        array(
            'name' => 'Dr. Grace Mukami',
            'position' => 'Community Health Coordinator',
            'member_since' => '2018',
            'member_type' => 'Faculty Member',
            'rating' => 5,
            'content' => 'The health insurance scheme through the SACCO has been a great benefit. When my family needed medical care, the coverage was comprehensive and the claims process was smooth.',
            'categories' => array('products-services', 'membership-benefits')
        ),
        array(
            'name' => 'Thomas Waweru',
            'position' => 'Transport Officer',
            'member_since' => '2019',
            'member_type' => 'Staff Member',
            'rating' => 5,
            'content' => 'The asset financing loan helped me purchase a commercial vehicle. The SACCO\'s understanding of our business needs and flexible repayment terms made it possible to expand my transport business.',
            'categories' => array('special-loans', 'development-loans')
        )
    );
}

// Create testimonials
function daystar_create_testimonials() {
    $testimonials = daystar_get_kenyan_testimonials();
    $created_count = 0;
    
    foreach ($testimonials as $testimonial) {
        // Check if testimonial already exists
        $existing = get_posts(array(
            'post_type' => 'testimonial',
            'title' => $testimonial['name'],
            'post_status' => 'any',
            'numberposts' => 1
        ));
        
        if (!empty($existing)) {
            continue; // Skip if already exists
        }
        
        // Create the testimonial post
        $post_id = wp_insert_post(array(
            'post_title' => $testimonial['name'],
            'post_content' => $testimonial['content'],
            'post_status' => 'publish',
            'post_type' => 'testimonial',
            'meta_input' => array(
                '_testimonial_rating' => $testimonial['rating'],
                '_member_since' => $testimonial['member_since'],
                '_member_type' => $testimonial['member_type'],
                '_position' => $testimonial['position']
            )
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // Assign categories
            $category_ids = array();
            foreach ($testimonial['categories'] as $category_slug) {
                $term = get_term_by('slug', $category_slug, 'testimonial_category');
                if ($term) {
                    $category_ids[] = $term->term_id;
                }
            }
            
            if (!empty($category_ids)) {
                wp_set_post_terms($post_id, $category_ids, 'testimonial_category');
            }
            
            $created_count++;
        }
    }
    
    return $created_count;
}

// Main execution function
function daystar_populate_testimonials() {
    echo "<h1>Daystar SACCO Testimonials Population Script</h1>\n";
    
    // Register taxonomy
    daystar_register_testimonial_category_taxonomy();
    echo "<p>✓ Testimonial category taxonomy registered</p>\n";
    
    // Create categories
    daystar_create_testimonial_categories();
    echo "<p>✓ Testimonial categories created</p>\n";
    
    // Create testimonials
    $created_count = daystar_create_testimonials();
    echo "<p>✓ Created {$created_count} new testimonials</p>\n";
    
    // Flush rewrite rules
    flush_rewrite_rules();
    echo "<p>✓ Rewrite rules flushed</p>\n";
    
    echo "<h2>Summary</h2>\n";
    echo "<p>The script has successfully:</p>\n";
    echo "<ul>\n";
    echo "<li>Created testimonial categories for different pages/services</li>\n";
    echo "<li>Populated {$created_count} Kenyan testimonials with authentic names and experiences</li>\n";
    echo "<li>Categorized testimonials for appropriate display on different pages</li>\n";
    echo "</ul>\n";
    
    echo "<h2>Usage Instructions</h2>\n";
    echo "<p>To display testimonials on specific pages, use the testimonial_category parameter in your queries:</p>\n";
    echo "<pre>\n";
    echo "// For development loans page:\n";
    echo "\$testimonials = new WP_Query(array(\n";
    echo "    'post_type' => 'testimonial',\n";
    echo "    'posts_per_page' => 3,\n";
    echo "    'tax_query' => array(\n";
    echo "        array(\n";
    echo "            'taxonomy' => 'testimonial_category',\n";
    echo "            'field' => 'slug',\n";
    echo "            'terms' => 'development-loans'\n";
    echo "        )\n";
    echo "    )\n";
    echo "));\n";
    echo "</pre>\n";
    
    echo "<h2>Available Categories</h2>\n";
    $categories = get_terms(array(
        'taxonomy' => 'testimonial_category',
        'hide_empty' => false
    ));
    
    if (!empty($categories)) {
        echo "<ul>\n";
        foreach ($categories as $category) {
            $count = wp_count_posts('testimonial');
            echo "<li><strong>{$category->name}</strong> (slug: {$category->slug}) - {$category->description}</li>\n";
        }
        echo "</ul>\n";
    }
    
    echo "<p><strong>Script completed successfully!</strong></p>\n";
}

// Run the script if accessed directly
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    daystar_populate_testimonials();
}
?>