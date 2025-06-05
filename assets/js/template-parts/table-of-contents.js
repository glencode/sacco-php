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
