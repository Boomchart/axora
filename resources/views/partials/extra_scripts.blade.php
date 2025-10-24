@if (session('success'))
<script>
    "use strict";
    createToast("success", "{!! session('success') !!}");
</script>
@endif

@if (session('alert'))
<script>
    "use strict";
    createToast("warning", "{!! session('alert') !!}");
</script>
@endif


<script>
    function showSpinner(A) {
        var o = document.createElement("div");
        if ("show" === A) {
            const A = document.createElement("style");
            (A.textContent =
                ".page-loading{position:fixed;top:0;right:0;bottom:0;left:0;width:100%;height:100%;-webkit-transition:all .4s .2s ease-in-out;transition:all .4s .2s ease-in-out;background-color:rgba(0, 0, 0, 0.5);-webkit-backdrop-filter: blur(10px);backdrop-filter: blur(10px);visibility:hidden;z-index:9999}.dark-mode .page-loading{background-color:#0b0f19}.page-loading.active{opacity:1;visibility:visible}.page-loading-inner{position:absolute;top:50%;left:0;width:100%;text-align:center;-webkit-transform:translateY(-50%);transform:translateY(-50%);-webkit-transition:opacity .2s ease-in-out;transition:opacity .2s ease-in-out;opacity:0}.page-loading.active>.page-loading-inner{opacity:1}.page-loading-inner>span{display:block;font-size:1rem;font-weight:400;color:#9397ad}.dark-mode .page-loading-inner>span{color:#fff;opacity:.6}.page-spinner{display:inline-block;width:2.75rem;height:2.75rem;margin-bottom:.75rem;vertical-align:text-bottom;border:.10em solid #fff;border-right-color:transparent;border-radius:50%;-webkit-animation:spinner .15s linear infinite;animation:spinner .25s linear infinite}.dark-mode .page-spinner{border-color:rgba(255,255,255,.4);border-right-color:transparent}@-webkit-keyframes spinner{100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}"),
            document.head.appendChild(A),
                document.documentElement.appendChild(Object.assign(o, {
                    innerHTML: '<div class="page-loading active text-white"><div class="page-loading-inner"><div class="page-spinner"></div></div></div>'
                }));
        } else {
            const A = document.createElement("style");
            (A.textContent = "html,body{margin: 0;overflow-y: visible}"), document.head.appendChild(A), document.querySelector('.page-loading').remove();
        }
    }

    (function() {
        window.onload = function() {
            const preloader = document.querySelector('.page-loading');
            preloader.classList.remove('active');
            setTimeout(function() {
                preloader.remove();
            }, 1000);
        };
    })();

    window.livewire.on('success', data => {
        createToast("success", data);
    });

    window.livewire.on('alert', data => {
        createToast("alert", data);
    });

    window.livewire.on('closeModal', data => {
        $('#' + data).modal('hide');
    });

    window.livewire.on('drawer', data => {
        if (data == null) {
            KTDrawer.hideAll();
        } else {
            var drawerElement = document.querySelector(data);
            var drawer = KTDrawer.getInstance(drawerElement);
            drawer.hide();
        }
        KTDrawer.createInstances();
    });

    window.livewire.on('searchdrawer', data => {
        KTDrawer.createInstances();
    });

    Livewire.on('avatar', data => {
        Livewire.emit('eventAvatar', data);
    });

    Livewire.on('saved', data => {
        Livewire.emit('refreshMenu', data);
    });

    Livewire.on('drawer', data => {
        $('div[data-href]').on("click", function() {
            window.location.href = $(this).data('href');
        });
    });

    $('div[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });

    $('tr[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });

    $('span[data-href]').on("click", function() {
        window.location.href = $(this).data('href');
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Find the active element with the "active" class
        const activeNavItem = document.querySelector('.menu-item.active');

        if (activeNavItem) {
            // Scroll to the active element
            activeNavItem.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    });

    function gallery() {
        var e = document.querySelectorAll(".gallery");
        if (e.length)
            for (var t = 0; t < e.length; t++) {
                var r = !!e[t].dataset.thumbnails,
                    a = !!e[t].dataset.video,
                    n = [lgZoom, lgFullscreen],
                    a = a ? [lgVideo] : [],
                    r = r ? [lgThumbnail] : [],
                    r = [].concat(n, a, r);
                lightGallery(e[t], {
                    selector: ".gallery-item",
                    plugins: r,
                    licenseKey: "D4194FDD-48924833-A54AECA3-D6F8E646",
                    download: !1,
                    autoplayVideoOnSlide: !0,
                    zoomFromOrigin: !1,
                    youtubePlayerParams: {
                        modestbranding: 1,
                        showinfo: 0,
                        rel: 0
                    },
                    vimeoPlayerParams: {
                        byline: 0,
                        portrait: 0,
                        color: "6366f1"
                    }
                })
            }
    };
    gallery();
</script>