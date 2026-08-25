<?php
/**
 * Build-time extractor: turns the captured WordPress homepage render into a
 * Blade layout (head + site header + footer) plus the home page content.
 * Run once:  php scripts/extract_layout.php
 */

$capture = 'E:/xampp/htdocs/_wpcapture/home.html';
$html = file_get_contents($capture);
if ($html === false) {
    fwrite(STDERR, "Cannot read $capture\n");
    exit(1);
}

/** Rewrite legacy absolute URLs to local, root-relative paths. */
function rewrite(string $s): string
{
    $map = [
        '#https?://www\.makhahtaxi\.com/wp-content/uploads#i' => '/wp-uploads',
        '#https?://localhost/makhahtaxi/wp-content/uploads#i'  => '/wp-uploads',
        '#https?://www\.makhahtaxi\.com/wp-content#i'          => '/wp-content',
        '#https?://localhost/makhahtaxi/wp-content#i'          => '/wp-content',
        '#https?://localhost/makhahtaxi/wp-includes#i'         => '/wp-includes',
        '#https?://www\.makhahtaxi\.com/wp-includes#i'         => '/wp-includes',
        '#https?://localhost/makhahtaxi/?#i'                   => '/',
        '#https?://www\.makhahtaxi\.com/?#i'                   => '/',
    ];
    return preg_replace(array_keys($map), array_values($map), $s);
}

$lines = preg_split('/\r\n|\n/', $html);
// 1-based line numbers from inspection:
//   head/body open : 1 .. 307
//   wp-site-blocks + header : 308 .. 426
//   home main content : 427 .. 2193
//   footer + closing scripts : 2194 .. end
$slice = fn (int $from, int $to) => implode("\n", array_slice($lines, $from - 1, $to - $from + 1));

$topRaw     = rewrite($slice(1, 426));       // <head> ... </head><body> ... </header>
$contentRaw = rewrite($slice(427, 2193));    // homepage content
$footRaw    = rewrite($slice(2194, count($lines)));

// Split the <head> at <title> so we can inject a dynamic per-page title.
$top = preg_replace('#<title>.*?</title>#is', '@@TITLE@@', $topRaw, 1);
[$beforeTitle, $afterTitle] = array_pad(explode('@@TITLE@@', $top, 2), 2, '');

// Inject a seam right before </head> so pages can add their own CSS/head bits.
$headSeam = "@endverbatim\n<link rel=\"stylesheet\" href=\"/assets/site.css?v=2\">\n@stack('styles')\n@verbatim\n</head>";
$afterTitle = preg_replace('#</head>#i', $headSeam, $afterTitle, 1);

$layout = "@verbatim\n" . $beforeTitle . "\n@endverbatim\n"
        . "<title>@yield('title', 'Makhah Taxi | Premium Cab & Airport Transfers')</title>\n"
        . "@verbatim\n" . $afterTitle . "\n@endverbatim\n\n"
        . "@yield('content')\n\n"
        . "@verbatim\n" . $footRaw . "\n@endverbatim\n";

$home = "@extends('layouts.wp')\n\n@section('content')\n"
      . "@verbatim\n" . $contentRaw . "\n@endverbatim\n@endsection\n";

@mkdir(__DIR__ . '/../resources/views/layouts', 0777, true);
@mkdir(__DIR__ . '/../resources/views/pages', 0777, true);
file_put_contents(__DIR__ . '/../resources/views/layouts/wp.blade.php', $layout);
file_put_contents(__DIR__ . '/../resources/views/pages/home.blade.php', $home);

echo "Wrote layouts/wp.blade.php (" . strlen($layout) . " bytes)\n";
echo "Wrote pages/home.blade.php (" . strlen($home) . " bytes)\n";
