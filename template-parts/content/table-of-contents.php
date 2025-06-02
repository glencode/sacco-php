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
        wp_update_post($post_copy);
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

<style>
.toc-container {
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: var(--border-radius-sm);
    overflow: hidden;
}

.toc-header {
    padding: 1rem;
    background-color: #f1f3f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.toc-header h4 {
    margin: 0;
    font-size: 1.1rem;
}

.toc-content {
    padding: 1rem;
    display: none;
}

.toc-content.active {
    display: block;
}

.toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.toc-item {
    padding: 0.3rem 0;
}

.toc-link {
    color: var(--primary-color);
    text-decoration: none;
}

.toc-link:hover {
    text-decoration: underline;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tocToggle = document.getElementById('toc-toggle');
    const tocContent = document.getElementById('toc-content');
    const tocIcon = document.querySelector('.toc-toggle-icon i');
    
    if (tocToggle && tocContent) {
        // Show TOC by default
        tocContent.classList.add('active');
        
        tocToggle.addEventListener('click', function() {
            tocContent.classList.toggle('active');
            
            // Toggle icon
            if (tocContent.classList.contains('active')) {
                tocIcon.classList.remove('fa-chevron-right');
                tocIcon.classList.add('fa-chevron-down');
            } else {
                tocIcon.classList.remove('fa-chevron-down');
                tocIcon.classList.add('fa-chevron-right');
            }
        });
    }
    
    // Smooth scroll for TOC links
    const tocLinks = document.querySelectorAll('.toc-link');
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
<?php endif; ?> 