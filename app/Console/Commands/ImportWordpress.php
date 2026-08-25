<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Post;
use App\Models\Vehicle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ImportWordpress extends Command
{
    protected $signature = 'wp:import {--fresh : Truncate target tables before importing}';

    protected $description = 'Import fleet, pages and blog posts from the legacy WordPress database (connection: wp)';

    /** Slugs that represent fleet vehicles (everything else that is a page becomes a CMS page). */
    private array $vehicleSlugs = [
        'camry-cars', 'coaster-saloon-5c', 'hyundai-staria',
        'gmc-yukon-xl-2024', 'toyota-hiace', 'luxury-bus-2',
    ];

    /** Content pages to bring across as CMS pages. */
    private array $pageSlugs = ['about-us', 'contact-us', 'our-taxis'];

    public function handle(): int
    {
        $wp = DB::connection('wp');

        if ($this->option('fresh')) {
            Schema::disableForeignKeyConstraints();
            Vehicle::truncate();
            Page::truncate();
            Post::truncate();
            Schema::enableForeignKeyConstraints();
            $this->warn('Truncated vehicles, pages, posts.');
        }

        $this->importVehicles($wp);
        $this->importPages($wp);
        $this->importPosts($wp);

        $this->newLine();
        $this->info('WordPress import complete.');
        $this->line("Vehicles: " . Vehicle::count() . " | Pages: " . Page::count() . " | Posts: " . Post::count());

        return self::SUCCESS;
    }

    private function importVehicles($wp): void
    {
        $this->info('Importing fleet vehicles...');
        $rows = $wp->table('posts')
            ->where('post_type', 'page')
            ->where('post_status', 'publish')
            ->whereIn('post_name', $this->vehicleSlugs)
            ->get();

        foreach ($rows as $i => $row) {
            $html    = $this->cleanHtml($row->post_content);
            $images  = $this->images($html);
            Vehicle::updateOrCreate(
                ['wp_id' => $row->ID],
                [
                    'name'        => $row->post_title,
                    'slug'        => $row->post_name,
                    'excerpt'     => Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($html))), 160),
                    'description' => $html,
                    'image'       => $images[0] ?? null,
                    'gallery'     => array_slice($images, 0, 8),
                    'passengers'  => $this->guessPassengers($row->post_title),
                    'luggage'     => 3,
                    'base_fare'   => 15,
                    'per_km'      => 2.5,
                    'per_hour'    => 25,
                    'min_fare'    => 20,
                    'sort_order'  => $i,
                    'is_active'   => true,
                ]
            );
            $this->line("  + {$row->post_title}");
        }
    }

    private function importPages($wp): void
    {
        $this->info('Importing content pages...');
        $rows = $wp->table('posts')
            ->where('post_type', 'page')
            ->where('post_status', 'publish')
            ->whereIn('post_name', $this->pageSlugs)
            ->get();

        foreach ($rows as $row) {
            Page::updateOrCreate(
                ['wp_id' => $row->ID],
                [
                    'title'        => $row->post_title,
                    'slug'         => $row->post_name,
                    'content'      => $this->cleanHtml($row->post_content),
                    'is_published' => true,
                ]
            );
            $this->line("  + {$row->post_title}");
        }
    }

    private function importPosts($wp): void
    {
        $this->info('Importing blog posts...');
        $rows = $wp->table('posts')
            ->where('post_type', 'post')
            ->where('post_status', 'publish')
            ->orderByDesc('post_date')
            ->get();

        foreach ($rows as $row) {
            $html   = $this->cleanHtml($row->post_content);
            $images = $this->images($html);
            $slug   = $row->post_name ?: Str::slug($row->post_title) ?: 'post-' . $row->ID;

            Post::updateOrCreate(
                ['wp_id' => $row->ID],
                [
                    'title'        => $row->post_title ?: 'Untitled',
                    'slug'         => $slug,
                    'excerpt'      => Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($html))), 200),
                    'content'      => $html,
                    'image'        => $images[0] ?? null,
                    'is_published' => true,
                    'published_at' => $row->post_date,
                ]
            );
        }
        $this->line("  imported {$rows->count()} posts");
    }

    /** Strip Gutenberg block comments and rewrite legacy asset URLs to the local /wp-uploads path. */
    private function cleanHtml(?string $html): string
    {
        $html = (string) $html;
        // remove <style>/<script> blocks entirely (tag + inner CSS/JS) so they
        // never leak into excerpts (strip_tags would keep the inner text) or the page
        $html = preg_replace('#<(style|script)\b[^>]*>.*?</\1>#is', '', $html);
        // remove <!-- wp:... --> and <!-- /wp:... --> block delimiters
        $html = preg_replace('/<!--\s*\/?wp:.*?-->/s', '', $html);
        return $this->rewriteUrls($html);
    }

    private function rewriteUrls(string $html): string
    {
        $patterns = [
            '#https?://www\.makhahtaxi\.com/wp-content/uploads#i',
            '#https?://makhahtaxi\.com/wp-content/uploads#i',
            '#https?://localhost/makhahtaxi/wp-content/uploads#i',
            '#/wp-content/uploads#i',
        ];
        return preg_replace($patterns, '/wp-uploads', $html);
    }

    /** Collect real image src URLs from HTML (inline base64 data-URIs are ignored). */
    private function images(string $html): array
    {
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m);
        $urls = array_filter(
            array_unique($m[1] ?? []),
            fn ($u) => ! Str::startsWith($u, 'data:')
        );
        return array_values(array_map(fn ($u) => $this->rewriteUrls($u), $urls));
    }

    private function guessPassengers(string $title): int
    {
        $t = strtolower($title);
        return match (true) {
            str_contains($t, 'bus')      => 30,
            str_contains($t, 'coaster')  => 20,
            str_contains($t, 'hiace')    => 12,
            str_contains($t, 'staria')   => 7,
            str_contains($t, 'yukon')    => 6,
            default                      => 4,
        };
    }
}
