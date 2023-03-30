<?php

use App\Models\User;

$keys = [];

$redisExtras = [
    // ['table' => 'organisations', 'roles' => [User::ROLE_ADMIN, User::ROLE_SUPERADMIN]],

    'configurations',
    // 'countries', 'seos', 'policy_pages',
];

$domainWiseEntities = [
    // ['name' => 'currencies', 'model' => '\App\Models\Currency'],
];

$models = [
];

$staticData = [
    ['key' => 'statuses', 'data' => User::STATUSES, 'roles' => [User::ROLE_ADMIN, User::ROLE_SUPERADMIN]],
    ['key' => 'roles', 'data' => User::ROLE_HUMANS, 'roles' => [User::ROLE_ADMIN, User::ROLE_SUPERADMIN]],
];

return [
    /*
    |--------------------------------------------------------------------------
    | Redis Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls redis
    |
    |
    */

    /**
     * Redis prefix to facilitate searches on a module and creation of database builder
     * For example, within redis configuration templates, we execute the method DB::table(settings_*)
     * Prefix is appended to items store within the redis server
     */
    'prefix' => 'settings',

    'keys' => $keys,

    'extras' => $redisExtras,

    'models' => $models,

    'static_data' => $staticData,

    /**
     * specify the entities that are fetched domain-wise
     */
    'domain_wise_entities' => $domainWiseEntities,

    /**
     * Specify Configuration Model to use.
     * Replace with AceLords Project Namespace
     */
    'defaults' => [
        'models' => [
            'configuration' => 'App\Models\Configuration',
        ],

        'tables' => [
            'configurations' => 'configurations',
        ]
    ],

    /**
     * Specify the values to return in site-info
     * templates on the front-end
     */
    'site_info_keys' => [
        'site_address',
        'site_bio',
        'site_building',
        'site_buymecoffee',
        'site_country',
        'site_discord',
        'site_dribble',
        'site_email',
        'site_facebook',
        'site_fax',
        'site_github',
        'site_instagram',
        'site_linkedin',
        'site_mobile',
        'site_name',
        'site_office',
        'site_patreon',
        'site_pinterest',
        'site_slogan',
        'site_street',
        'site_support_email',
        'site_telegram',
        'site_telephone',
        'site_theme_color',
        'site_town',
        'site_twitter',
        'site_version',
        'site_whatsapp',
        'site_youtube',
        'title_separator',
    ]

];
