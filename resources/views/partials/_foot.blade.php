{!!$set->livechat!!}
{!!$set->analytic_snippet!!}

<script src="{{asset('front/js/bootstrap.bundle.min.js')}}"></script>

<!-- Prism.js for Syntax Highlighting -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-ruby.min.js"></script>

<script src="{{asset('front/vendor/@lottiefiles/lottie-player/dist/lottie-player.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.6/lottie_svg.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.8.9/dist/cookieconsent.js"></script>
<script src="{{asset('front/js/cookie.js')}}"></script>
<script src="{{asset('front/js/toast.js')}}"></script>
{{--<script src="{{asset('asset/fonts/fontawesome/js/all.js')}}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.min.js"></script>
@livewireScripts

<script src="{{asset('dashboard/js/alpine.js')}}"></script>
@yield('script')
@stack('script')
@if (session('success'))
    <script>
        "use strict";
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.closeButton = true;
        toastr.success("{!! session('success') !!}");
    </script>
@endif

@if (session('alert'))
    <script>
        "use strict";
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.options.closeButton = true;
        toastr.warning("{!! session('alert') !!}");
    </script>
@endif

@if($set->recaptcha==1)
    {!! RecaptchaV3::initJs() !!}
@endif




<!-- Code Snippet Tab Switcher -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const codeTabs = document.querySelectorAll('.code-tab');
        const codeBlocks = document.querySelectorAll('.code-block');

        codeTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');

                // Remove active class from all tabs and blocks
                codeTabs.forEach(t => t.classList.remove('active'));
                codeBlocks.forEach(b => b.classList.remove('active'));

                // Add active class to clicked tab
                this.classList.add('active');

                // Show corresponding code block
                const activeBlock = document.querySelector(`.code-block[data-lang="${lang}"]`);
                if (activeBlock) {
                    activeBlock.classList.add('active');

                    // Re-highlight with Prism if available
                    if (typeof Prism !== 'undefined') {
                        Prism.highlightAllUnder(activeBlock);
                    }
                }
            });
        });

        // Copy to clipboard functionality
        const copyBtn = document.querySelector('.code-copy-btn');

        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const activeBlock = document.querySelector('.code-block.active');
                const codeText = activeBlock.querySelector('code').textContent;

                // Copy to clipboard
                navigator.clipboard.writeText(codeText).then(() => {
                    // Change icon temporarily
                    const icon = this.querySelector('i');
                    const originalClass = icon.className;

                    icon.className = 'bi bi-check2';
                    this.classList.add('copied');

                    setTimeout(() => {
                        icon.className = originalClass;
                        this.classList.remove('copied');
                    }, 2000);
                }).catch(err => {
                    console.error('Failed to copy:', err);
                });
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggler = document.querySelector('.axora-menu-toggler');
        const menuClose = document.querySelector('.axora-mobile-close');
        const backdrop = document.querySelector('.axora-mobile-backdrop');
        const mobileLinks = document.querySelectorAll('.axora-mobile-nav a');

        const openMenu = () => {
            document.body.classList.add('axora-menu-open');
        };

        const closeMenu = () => {
            document.body.classList.remove('axora-menu-open');
        };

        if (menuToggler) {
            menuToggler.addEventListener('click', openMenu);
        }

        if (menuClose) {
            menuClose.addEventListener('click', closeMenu);
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeMenu);
        }

        mobileLinks.forEach((link) => {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });
    });
</script>
@livewireScripts
</body>
</html>