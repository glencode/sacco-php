<?php
/**
 * Template Name: Downloads Page
 *
 * The template for displaying downloadable forms and documents.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sacco-php
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="page-header bg-light py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="downloads-intro-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<h2 class="section-title"><?php echo esc_html(get_field('downloads_intro_title') ?: 'SACCO Documents & Forms'); ?></h2>
					<?php
					// Display page content from editor for introduction
					if (have_posts()) :
						while ( have_posts() ) :
							the_post();
							if(get_the_content()){
								the_content();
							} else {
                                echo '<p class="lead mb-0">Access all the forms and important documents you need for our services. Find membership forms, loan applications, financial reports, and more.</p>';
                            }
						endwhile;
					endif;
					?>
				</div>
			</div>
		</div>
	</section>
	
	<section class="downloads-section py-5 bg-light">
		<div class="container">
            <?php
            $resource_types = get_terms(array(
                'taxonomy' => 'resource_type',
                'hide_empty' => true, // Only show terms that have posts
                'orderby' => 'name',
                'order' => 'ASC',
                // 'parent' => 0, // Uncomment to get only top-level terms if using hierarchical terms for tabs
            ));

            if (!empty($resource_types) && !is_wp_error($resource_types)):
            ?>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs nav-justified download-tabs mb-5" id="downloadTabs" role="tablist">
                <?php foreach ($resource_types as $index => $term): 
                    $active_class = ($index == 0) ? 'active' : '';
                    $aria_selected = ($index == 0) ? 'true' : 'false';
                    // Simple icon mapping - can be expanded or made a term meta
                    $icon_map = [
                        'forms' => 'fa-wpforms',
                        'membership-forms' => 'fa-user-plus',
                        'loan-forms' => 'fa-hand-holding-usd',
                        'fosa-forms' => 'fa-university',
                        'governance-documents' => 'fa-gavel',
                        'reports' => 'fa-chart-line',
                        'by-laws' => 'fa-balance-scale',
                        'financial-reports' => 'fa-file-invoice-dollar',
                        'agm-minutes' => 'fa-users',
                        'strategic-plan' => 'fa-lightbulb'
                    ];
                    $icon = isset($icon_map[$term->slug]) ? $icon_map[$term->slug] : 'fa-file-alt';
                ?>
				<li class="nav-item" role="presentation">
					<button class="nav-link <?php echo esc_attr($active_class); ?>" id="<?php echo esc_attr($term->slug); ?>-tab" data-bs-toggle="tab" data-bs-target="#<?php echo esc_attr($term->slug); ?>" type="button" role="tab" aria-controls="<?php echo esc_attr($term->slug); ?>" aria-selected="<?php echo esc_attr($aria_selected); ?>">
						<i class="fas <?php echo esc_attr($icon); ?> me-2"></i><?php echo esc_html($term->name); ?>
					</button>
				</li>
                <?php endforeach; ?>
			</ul>
			
			<!-- Tab panes -->
			<div class="tab-content" id="downloadTabsContent">
                <?php foreach ($resource_types as $index => $term): 
                    $active_class = ($index == 0) ? 'show active' : '';
                ?>
				<div class="tab-pane fade <?php echo esc_attr($active_class); ?>" id="<?php echo esc_attr($term->slug); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr($term->slug); ?>-tab">
					<div class="row g-4">
                        <?php
                        $args = array(
                            'post_type' => 'download',
                            'posts_per_page' => -1, // Show all downloads in this category
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'resource_type',
                                    'field'    => 'slug',
                                    'terms'    => $term->slug,
                                ),
                            ),
                            'orderby' => 'title',
                            'order' => 'ASC' 
                        );
                        $downloads_query = new WP_Query($args);

                        if ($downloads_query->have_posts()) :
                            while ($downloads_query->have_posts()) : $downloads_query->the_post();
                                $file_url = get_post_meta(get_the_ID(), '_download_file_url', true);
                                $file_version = get_post_meta(get_the_ID(), '_file_version', true);
                                $file_publish_date = get_post_meta(get_the_ID(), '_file_publish_date', true);
                                $file_description = get_the_excerpt();
                                if(empty($file_description)) {
                                    $file_description = wp_trim_words(get_the_content(), 25, '...');
                                }
                                // Basic file type icon detection based on URL (can be improved)
                                $file_icon = 'fa-file-alt'; // default
                                if ($file_url) {
                                    $file_extension = pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_EXTENSION);
                                    if ($file_extension === 'pdf') $file_icon = 'fa-file-pdf text-danger';
                                    elseif (in_array($file_extension, ['doc', 'docx'])) $file_icon = 'fa-file-word text-primary';
                                    elseif (in_array($file_extension, ['xls', 'xlsx'])) $file_icon = 'fa-file-excel text-success';
                                    elseif (in_array($file_extension, ['ppt', 'pptx'])) $file_icon = 'fa-file-powerpoint text-warning';
                                    elseif (in_array($file_extension, ['zip', 'rar'])) $file_icon = 'fa-file-archive text-info';
                                }
                        ?>  
						<div class="col-md-6 col-lg-4 d-flex align-items-stretch">
							<div class="card download-card h-100 border-0 shadow-sm w-100">
								<div class="card-body d-flex flex-column">
									<div class="download-icon mb-3">
										<i class="fas <?php echo esc_attr($file_icon); ?> fa-3x"></i>
									</div>
									<h3 class="card-title h5"><?php the_title(); ?></h3>
									<?php if ($file_description): ?>
                                        <p class="card-text small text-muted flex-grow-1"><?php echo esc_html($file_description); ?></p>
                                    <?php endif; ?>
									<ul class="list-unstyled mb-4 small text-muted mt-auto">
                                        <?php if ($file_version): ?>
										    <li><i class="fas fa-code-branch me-2 text-primary"></i>Version: <?php echo esc_html($file_version); ?></li>
                                        <?php endif; ?>
                                        <?php if ($file_publish_date): ?>
										    <li><i class="fas fa-calendar-alt me-2 text-primary"></i>Published: <?php echo esc_html(date_format(date_create($file_publish_date), 'M j, Y')); ?></li>
                                        <?php endif; ?>
									</ul>
                                    <?php if ($file_url): ?>
									    <a href="<?php echo esc_url($file_url); ?>" class="btn btn-primary w-100" target="_blank" rel="noopener noreferrer">Download</a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary w-100" disabled>Not Available</button>
                                    <?php endif; ?>
								</div>
							</div>
						</div>
                        <?php 
                            endwhile;
                            wp_reset_postdata();
                        else:
                            echo '<div class="col-12"><p>No downloads found in this category.</p></div>';
                        endif;
                        ?>
					</div>
				</div>
                <?php endforeach; ?>
			</div>
            <?php else: ?>
                <p class="text-center">No download categories found or no documents have been uploaded yet.</p>
            <?php endif; // end if !empty($resource_types) ?>
		</div>
	</section>
	
	<section class="download-help-section py-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="card border-0 shadow-sm">
						<div class="card-body p-4 p-md-5">
							<div class="row align-items-center">
								<div class="col-md-8">
									<h2>Need Help with Forms?</h2>
									<p class="lead mb-4">Our team is ready to assist you with filling out forms or answering any questions you might have.</p>
									<div class="contact-options">
										<div class="d-flex align-items-center mb-3">
											<div class="contact-icon me-3">
												<i class="fas fa-phone-alt fa-2x text-primary"></i>
											</div>
											<div class="contact-info">
												<h4 class="h5 mb-1">Call Us</h4>
												<p class="mb-0">+254 700 000 000</p>
											</div>
										</div>
										<div class="d-flex align-items-center mb-3">
											<div class="contact-icon me-3">
												<i class="fas fa-envelope fa-2x text-primary"></i>
											</div>
											<div class="contact-info">
												<h4 class="h5 mb-1">Email Us</h4>
												<p class="mb-0">info@sacconame.co.ke</p>
											</div>
										</div>
										<div class="d-flex align-items-center">
											<div class="contact-icon me-3">
												<i class="fas fa-map-marker-alt fa-2x text-primary"></i>
											</div>
											<div class="contact-info">
												<h4 class="h5 mb-1">Visit Our Office</h4>
												<p class="mb-0">123 Main Street, Nairobi, Kenya</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4 text-center mt-4 mt-md-0">
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/customer-service.svg" alt="Customer Service" class="img-fluid" style="max-width: 200px;">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer(); 
?> 