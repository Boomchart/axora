// ===========================
// Sidebar submenu toggle
// ===========================
function toggleSubmenu(event) {
    event.preventDefault();
    event.stopPropagation();

    const parentItem = event.currentTarget.closest('.sidebar-item');
    if (!parentItem) return;

    const submenu = parentItem.querySelector('.sidebar-submenu');
    if (!submenu) return;

    parentItem.classList.toggle('open');
    submenu.classList.toggle('show');
}

// ===========================
// Generate Table of Contents
// ===========================
document.addEventListener('DOMContentLoaded', function () {
    const content = document.querySelector('.docs-content');
    const tocList = document.getElementById('tocList');

    if (!content || !tocList) return;

    const headings = content.querySelectorAll('h2, h3');

    headings.forEach((heading, index) => {
        if (!heading.id) {
            heading.id = `heading-${index}`;
        }

        const li = document.createElement('li');
        const a = document.createElement('a');

        a.href = `#${heading.id}`;
        a.textContent = heading.textContent;

        if (heading.tagName === 'H3') {
            a.classList.add('toc-child-link');
        }

        li.appendChild(a);
        tocList.appendChild(li);
    });

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const id = entry.target.id;
                const tocLinks = document.querySelectorAll('.toc-list a');

                tocLinks.forEach((link) => {
                    link.classList.remove('active');

                    if (link.getAttribute('href') === `#${id}`) {
                        link.classList.add('active');
                    }
                });
            });
        },
        {
            rootMargin: '-100px 0px -66%',
            threshold: 0.1
        }
    );

    headings.forEach((heading) => observer.observe(heading));
});


// ===========================
// Copy code button
// ===========================
document.addEventListener('click', function (event) {
    const button = event.target.closest('.code-copy-button');

    if (!button) return;

    const wrapper = button.closest('.code-block-wrapper');

    let codeBlock = null;

    if (wrapper) {
        codeBlock = wrapper.querySelector('code');
    }

    if (!codeBlock) {
        const nextPre = button.closest('.code-block-header')?.nextElementSibling;
        codeBlock = nextPre ? nextPre.querySelector('code') : null;
    }

    if (!codeBlock) {
        console.warn('No code block found for copy button.');
        return;
    }

    const text = codeBlock.innerText || codeBlock.textContent || '';

    if (!text.trim()) {
        console.warn('Code block is empty.');
        return;
    }

    copyTextToClipboard(text)
        .then(function () {
            const originalText = button.dataset.originalText || button.textContent;

            button.dataset.originalText = originalText;
            button.textContent = 'Copied!';
            button.classList.add('copied');

            setTimeout(function () {
                button.textContent = originalText;
                button.classList.remove('copied');
            }, 2000);
        })
        .catch(function (error) {
            console.error('Copy failed:', error);

            const originalText = button.dataset.originalText || button.textContent;
            button.dataset.originalText = originalText;
            button.textContent = 'Failed';

            setTimeout(function () {
                button.textContent = originalText;
            }, 2000);
        });
});

function copyTextToClipboard(text) {
    if (navigator.clipboard && window.isSecureContext) {
        return navigator.clipboard.writeText(text);
    }

    return new Promise(function (resolve, reject) {
        const textarea = document.createElement('textarea');

        textarea.value = text;
        textarea.setAttribute('readonly', '');
        textarea.style.position = 'fixed';
        textarea.style.top = '-9999px';
        textarea.style.left = '-9999px';
        textarea.style.opacity = '0';

        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();

        try {
            const successful = document.execCommand('copy');
            document.body.removeChild(textarea);

            if (successful) {
                resolve();
            } else {
                reject(new Error('document.execCommand copy failed'));
            }
        } catch (error) {
            document.body.removeChild(textarea);
            reject(error);
        }
    });
}

// ===========================
// Mobile drawer
// ===========================
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const toggler = document.querySelector('.axora-doc-menu-toggler');
    const closeBtn = document.querySelector('.axora-doc-mobile-close');
    const backdrop = document.querySelector('.axora-doc-mobile-backdrop');
    const drawer = document.querySelector('.axora-doc-mobile-drawer');

    function openMenu() {
        body.classList.add('axora-doc-menu-open');

        if (drawer) {
            drawer.setAttribute('aria-hidden', 'false');
        }
    }

    function closeMenu() {
        body.classList.remove('axora-doc-menu-open');

        if (drawer) {
            drawer.setAttribute('aria-hidden', 'true');
        }
    }

    if (toggler) {
        toggler.addEventListener('click', openMenu);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeMenu);
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeMenu);
    }

    document.querySelectorAll('.axora-doc-mobile-submenu-toggle').forEach((toggle) => {
        toggle.addEventListener('click', function () {
            const parent = this.closest('.axora-doc-mobile-submenu-item');
            if (!parent) return;

            parent.classList.toggle('is-open');
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });
});

// ===========================
// Desktop sidebar submenu toggle
// ===========================
document.addEventListener('click', function (event) {
    const toggle = event.target.closest('.submenu-toggle');

    if (!toggle) return;

    event.preventDefault();

    const parent = toggle.closest('.has-submenu');
    const submenu = parent ? parent.querySelector('.sidebar-submenu') : null;

    if (!parent || !submenu) return;

    parent.classList.toggle('open');
    submenu.classList.toggle('show');
});