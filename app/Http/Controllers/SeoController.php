<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\HelpCenter;
use App\Models\Settings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    /**
     * Marketing/static routes that should always appear in the sitemap.
     * name => [changefreq, priority]
     */
    private array $staticRoutes = [
        'home'        => ['daily', '1.0'],
        'pricing'     => ['monthly', '0.8'],
        'solutions'   => ['monthly', '0.7'],
        'security'    => ['monthly', '0.6'],
        'help.center' => ['weekly', '0.6'],
        'terms'       => ['yearly', '0.3'],
        'privacy'     => ['yearly', '0.3'],
        'contact'     => ['yearly', '0.5'],
    ];

    /**
     * Dynamic robots.txt — keeps the sitemap URL and the (configurable)
     * admin path correct across every environment.
     */
    public function robots()
    {
        $adminUrl = optional(Settings::find(1))->admin_url;

        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /user',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /password',
            'Disallow: /onboarding',
        ];

        if (!empty($adminUrl)) {
            $lines[] = 'Disallow: /' . ltrim($adminUrl, '/');
        }

        $lines[] = '';
        $lines[] = 'Sitemap: ' . url('/sitemap.xml');

        return response(implode("\n", $lines) . "\n", 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    /**
     * Dynamic sitemap covering static marketing pages, developer docs,
     * gift-card category pages, blog posts, and help-center articles.
     */
    public function sitemap()
    {
        $urls = [];

        // Static marketing pages
        foreach ($this->staticRoutes as $name => [$changefreq, $priority]) {
            if (Route::has($name)) {
                $urls[] = ['loc' => route($name), 'changefreq' => $changefreq, 'priority' => $priority];
            }
        }

        // Developer docs / API reference (all named developer.* with no route params)
        foreach (Route::getRoutes() as $route) {
            $name = $route->getName();
            if ($name && Str::startsWith($name, 'developer.') && !Str::contains($route->uri(), '{')) {
                $urls[] = ['loc' => url($route->uri()), 'changefreq' => 'monthly', 'priority' => '0.5'];
            }
        }

        // Blog posts
        foreach (Blog::whereStatus(1)->whereNotNull('slug')->get() as $post) {
            $urls[] = [
                'loc'        => route('blog.article', ['blog' => $post->slug]),
                'lastmod'    => optional($post->updated_at ?? $post->created_at)->toAtomString(),
                'changefreq' => 'monthly',
                'priority'   => '0.7',
            ];
        }

        // Help-center articles
        foreach (HelpCenter::whereNotNull('slug')->get() as $article) {
            $urls[] = [
                'loc'        => route('help.article', ['article' => $article->slug]),
                'lastmod'    => optional($article->updated_at ?? $article->created_at)->toAtomString(),
                'changefreq' => 'monthly',
                'priority'   => '0.5',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc'], ENT_XML1) . '</loc>' . "\n";
            if (!empty($url['lastmod'])) {
                $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            }
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
