{{--
    Shared SEO <head> tags for the front-facing site.
    Per-page overrides — define any of these sections/stacks in the page view
    (do NOT write the directives here; Blade would execute them site-wide):
      - section "seo_title"        full custom title (overrides "$title - site_name")
      - section "meta_description" page description, ~155 chars
      - section "seo_image"        absolute Open Graph image URL
      - section "seo_type"         og:type, default "website" (use "article" for posts)
      - section "seo_canonical"    canonical URL, default current URL
      - stack   "ld"               extra JSON-LD <script> blocks
--}}
@php
    $seoSiteName  = $set->site_name ?? config('app.name');
    $seoTitle     = trim($__env->yieldContent('seo_title'))
                        ?: (isset($title) && $title !== '' ? $title . ' - ' . $seoSiteName : $seoSiteName);
    $seoDesc      = trim($__env->yieldContent('meta_description')) ?: ($set->site_desc ?? '');
    $seoCanonical = trim($__env->yieldContent('seo_canonical')) ?: url()->current();
    $seoImage     = trim($__env->yieldContent('seo_image')) ?: asset('asset/images/favicon.png');
    $seoType      = trim($__env->yieldContent('seo_type')) ?: 'website';
@endphp
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDesc }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $seoCanonical }}">

{{-- Open Graph --}}
<meta property="og:site_name" content="{{ $seoSiteName }}">
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDesc }}">
<meta property="og:url" content="{{ $seoCanonical }}">
<meta property="og:image" content="{{ $seoImage }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDesc }}">
<meta name="twitter:image" content="{{ $seoImage }}">

{{-- Organization structured data (site-wide) --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'Organization',
    'name'     => $seoSiteName,
    'url'      => url('/'),
    'logo'     => asset('asset/images/favicon.png'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@stack('ld')
