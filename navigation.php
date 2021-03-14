<?php

return [
    'Introduction' => 'docs/laravel/introduction',
    'Installation' => [
        'url' => 'docs/laravel/installation',
        'children' => [
            'Prerequisites' => 'docs/laravel/installation#prerequisites',
            'Queueing' => 'docs/laravel/installation#queueing',
        ],
    ],
    'Configuration' => [
        'url' => 'docs/laravel/configuration',
        'children' => [
            'Users & Items' => 'docs/laravel/configuration#users-and-items',
            'Interactions' => 'docs/laravel/configuration#interactions',
        ],
    ],
    'Seeding' => 'docs/laravel/seeding',
    'Getting Recommendations' => 'docs/laravel/recommendations',
];
