<?php

use Illuminate\Support\Str;

return [
    'baseUrl' => 'https://docs.reconengine.ai',
    'production' => false,
    'siteName' => 'Recon - World Class Recommendation Engine for Laravel',
    'siteDescription' => 'Recon is a recommendation engine as a service with an intuitive API. Built on the same foundation powering Amazon.com',

    // Algolia DocSearch credentials
    'docsearchApiKey' => '',
    'docsearchIndexName' => '',

    // navigation menu
    'navigation' => require_once('navigation.php'),

    // helpers
    'isActive' => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(function ($child) use ($page) {
                return trimPath($page->getPath()) == trimPath($child);
            });
        }
    },
    'url' => function ($page, $path) {
        return Str::startsWith($path, 'http') ? $path : '/' . trimPath($path);
    },
];
