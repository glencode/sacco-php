<?php
/**
 * Template part for displaying a download card.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sacco-php
 */

$post_id = get_the_ID();
$file_url = get_post_meta($post_id, '_download_file_url', true);
$file_version = get_post_meta($post_id, '_file_version', true);
$file_publish_date_meta = get_post_meta($post_id, '_file_publish_date', true);
$file_publish_date = $file_publish_date_meta ? date_format(date_create($file_publish_date_meta), 'M j, Y') : get_the_date('M j, Y');

// Basic file type detection from URL
$file_extension = $file_url ? pathinfo(parse_url($file_url, PHP_URL_PATH), PATHINFO_EXTENSION) : '';
$file_icon_class = 'fas fa-file-alt'; // Default icon
if ($file_extension) {
    switch (strtolower($file_extension)) {
        case 'pdf':
            $file_icon_class = 'fas fa-file-pdf';
            break;
        case 'doc':
        case 'docx':
            $file_icon_class = 'fas fa-file-word';
            break;
        case 'xls':
        case 'xlsx':
            $file_icon_class = 'fas fa-file-excel';
            break;
        case 'ppt':
        case 'pptx':
            $file_icon_class = 'fas fa-file-powerpoint';
            break;
        case 'zip':
        case 'rar':
            $file_icon_class = 'fas fa-file-archive';
            break;
        case 'txt':
            $file_icon_class = 'fas fa-file-alt';
            break;
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            $file_icon_class = 'fas fa-file-image';
            break;
    }
}
?>
<div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-4">
    <div class="card download-card h-100 shadow-sm border-0 w-100">
        <div class="card-body d-flex flex-column p-3">
            <div class="d-flex align-items-start mb-2">
                <i class="<?php echo esc_attr($file_icon_class); ?> fa-2x text-primary me-3 mt-1"></i>
                <div>
                    <h5 class="card-title mb-1 h6"><a href="<?php the_permalink(); ?>" class="text-decoration-none stretched-link"><?php the_title(); ?></a></h5>
                    <?php if (get_the_excerpt()) : ?>
                        <p class="card-text small text-muted mb-1"><?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 10, '...')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="download-meta small text-muted mt-auto">
                <?php if ($file_version) : ?>
                    <span class="me-2">Version: <?php echo esc_html($file_version); ?></span>
                <?php endif; ?>
                <?php if ($file_publish_date) : ?>
                    <span>Published: <?php echo esc_html($file_publish_date); ?></span>
                <?php endif; ?>
            </div>
            <?php if ($file_url) : ?>
                <a href="<?php echo esc_url($file_url); ?>" class="btn btn-sm btn-outline-primary mt-2 align-self-start" target="_blank" rel="noopener noreferrer">
                    <i class="fas fa-download me-1"></i> Download
                </a>
            <?php else: ?>
                 <p class="small text-danger mt-2 mb-0 align-self-start">Link unavailable</p>
            <?php endif; ?>
        </div>
    </div>
</div> 