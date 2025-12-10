// Toggle Submenu
function toggleSubmenu(event) {
    event.preventDefault();
    event.stopPropagation(); // Prevent event bubbling

    const parentItem = event.target.closest('.sidebar-item');
    const submenu = parentItem.querySelector('.sidebar-submenu');

    // Toggle open class and submenu visibility
    parentItem.classList.toggle('open');
    submenu.classList.toggle('show');
}

// Generate Table of Contents
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.docs-content');
    const tocList = document.getElementById('tocList');

    if (content && tocList) {
        const headings = content.querySelectorAll('h2, h3');

        headings.forEach((heading, index) => {
            // Add ID to heading if it doesn't have one
            if (!heading.id) {
                heading.id = `heading-${index}`;
            }

            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = `#${heading.id}`;
            a.textContent = heading.textContent;

            // Indent h3 headings
            if (heading.tagName === 'H3') {
                a.style.paddingLeft = '1.5rem';
                a.style.fontSize = '0.8125rem';
            }

            li.appendChild(a);
            tocList.appendChild(li);
        });

        // Highlight active section on scroll
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const id = entry.target.id;
                        const tocLinks = document.querySelectorAll('.toc-list a');
                        tocLinks.forEach((link) => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${id}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            },
            { rootMargin: '-100px 0px -66%' }
        );

        headings.forEach((heading) => observer.observe(heading));
    }
});

// Copy Code Button
document.querySelectorAll('.code-copy-button').forEach((button) => {
    button.addEventListener('click', function() {
        const codeBlock = this.closest('.code-block-wrapper').querySelector('code');
        const text = codeBlock.textContent;

        navigator.clipboard.writeText(text).then(() => {
            const originalText = this.textContent;
            this.textContent = 'Copied!';
            this.classList.add('copied');

            setTimeout(() => {
                this.textContent = originalText;
                this.classList.remove('copied');
            }, 2000);
        });
    });
});

// Mobile Sidebar Toggle
const sidebarToggle = document.createElement('button');
sidebarToggle.className = 'btn btn-primary d-lg-none position-fixed';
sidebarToggle.style.cssText = 'bottom: 2rem; right: 2rem; z-index: 1000; border-radius: 50%; width: 56px; height: 56px;';
sidebarToggle.innerHTML = '<i class="bi bi-list"></i>';
document.body.appendChild(sidebarToggle);

sidebarToggle.addEventListener('click', function() {
    document.querySelector('.docs-sidebar').classList.toggle('show');
});