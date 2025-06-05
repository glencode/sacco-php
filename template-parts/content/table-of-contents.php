<?php
/**
 * Template part for displaying a table of contents
 *
 * @package sacco-php
 */

// Get the content
$content = get_the_content();

// Find all headings
preg_match_all('/<h([2-3])[^>]*>(.*?)<\/h\1>/i', $content, $matches, PREG_SET_ORDER);

// If there are at least 2 headings, display table of contents
if (count($matches) >= 2) :
    // Generate unique IDs for headings if they don't have them
    $content_with_ids = $content;
    foreach ($matches as &$match) {
        $heading_text = strip_tags($match[2]);
        $heading_level = $match[1];
        
        // Check if heading already has an ID
        if (!preg_match('/id=["\']([^"\']+)["\']/i', $match[0], $id_matches)) {
            // Generate ID from heading text
            $id = sanitize_title($heading_text);
            
            // Replace original heading with one that has an ID
            $new_heading = str_replace("<h$heading_level", "<h$heading_level id=\"$id\"", $match[0]);
            $content_with_ids = str_replace($match[0], $new_heading, $content_with_ids);
            
            // Update match with ID for TOC
            $match['id'] = $id;
        } else {
            // Use existing ID
            $match['id'] = $id_matches[1];
        }
    }
    
    // Only update the content if we made changes
    if ($content_with_ids !== $content) {
        global $post;
        $post_copy = clone $post;
        $post_copy->post_content = $content_with_ids;
        // Problematic: Modifying post content on display. Commented out.
        // wp_update_post($post_copy);
    }
?>
<div class="toc-container mb-4">
    <div class="toc-header" id="toc-toggle">
        <h4><i class="fas fa-list-ul me-2"></i> Table of Contents</h4>
        <span class="toc-toggle-icon"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div class="toc-content" id="toc-content">
        <ul class="toc-list">
            <?php
            foreach ($matches as $match) :
                $heading_text = strip_tags($match[2]);
                $heading_level = $match[1];
                $heading_id = $match['id'];
                $indent_class = ($heading_level > 2) ? 'ms-3' : '';
            ?>
                <li class="toc-item <?php echo esc_attr($indent_class); ?>">
                    <a href="#<?php echo esc_attr($heading_id); ?>" class="toc-link">
                        <?php echo esc_html($heading_text); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?> 