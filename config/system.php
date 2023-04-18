<?php

use App\Models\User;

$appVersion = '0.0.2';

return [
    // App Version
    'version' => $appVersion,

    /*
    |--------------------------------------------------------------------------
    | Title Separator
    |--------------------------------------------------------------------------
    |
    | This option specifies the title separator for the system
    |
    */
    'title_separator' => '|',

    /*
    |--------------------------------------------------------------------------
    | Default System Roles
    |--------------------------------------------------------------------------
    |
    | This option specifies the system roles
    |
    */
    'system_roles' => User::ROLES,

    /*
    |--------------------------------------------------------------------------
    | System Defaults
    |--------------------------------------------------------------------------
    |
    | This option specifies the defaults for the system
    |
    */
    'defaults' => [
        'avatar' => 'avatar.png',
        'coverphoto' => 'coverphoto.jpg',
        'demo_username' => env('DEMO_USERNAME', 'acelords'),
        'demo_password' => env('DEMO_PASSWORD', 'acelords'),
    ],


    /*
    |--------------------------------------------------------------------------
    | Backend Routes for the system
    |--------------------------------------------------------------------------
    |
    | This option specifies the backend url. These routes are used by the
    | HandleInertiaRequests middleware to redirect to individual user-role auth pages.
    */
    'backend_routes' => [
        'dashboard',
        'account',
        'admin',
        'user',
        'notifications',
        'reviews',
        'messages',
        'portal', // client/user
    ],

    /*
    |--------------------------------------------------------------------------
    | System paginations
    |--------------------------------------------------------------------------
    |
    | This option controls the different paginations within the system
    |
    */
    'pagination' => [
        'xs' => 5,
        's' => 10,
        'm' => 25,
        'l' => 50,
        'xl' => 100,
        'p' => 7
    ],


    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    |
    | List of languages supported by AceLords System.
    |
    */
    'languages' => [
        // ["code"=>"ar", "name" => "Arabic"],
        // ["code"=>"nl", "name" => "Dutch"],
        ["code"=>"en", "name" => "English"],
        // ["code"=>"fr", "name" => "French"],
        // ["code"=>"de", "name" => "German"],
        // ["code"=>"it", "name" => "Italian"],
        // ["code"=>"lv", "name" => "Latvian"],
        // ["code"=>"pt_BR", "name" => "Portuguese (Brazilian)"],
        // ["code"=>"sr", "name" => "Serbian Latin"],
        // ["code"=>"es", "name" => "Spanish"],
        // ["code"=>"sv", "name"=> "Svenska"]
    ],

    /*
    |--------------------------------------------------------------------------
    | Socials
    |--------------------------------------------------------------------------
    |
    | List of all socials supported int he system
    |
    */
    'socials' => [
        ["slug" => "facebook", "name" => "Facebook", "icon" => 'mdi mdi-facebook'],
        ["slug" => "twitter", "name" => "Twitter", "icon" => 'mdi mdi-twitter'],
        ["slug" => "youtube", "name" => "YouTube", "icon" => 'mdi mdi-youtube'],
        ["slug" => "instagram", "name" => "Instagram", "icon" => 'mdi mdi-instagram'],
        ["slug" => "kofi", "name" => "Ko-Fi", "icon" => 'mdi mdi-coffee'],
        ["slug" => "github", "name" => "GitHub", "icon" => 'mdi mdi-github'],
        ["slug" => "gitlab", "name" => "GitLab", "icon" => 'mdi mdi-gitlab'],
        ["slug" => "twitch", "name" => "Twitch", "icon" => 'mdi mdi-twitch'],
        ["slug" => "linkedin", "name" => "LinkedIn", "icon" => 'mdi mdi-linkedin'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Authorization errors
    |--------------------------------------------------------------------------
    |
    | specify the auth code an default message
    |
    */
    'abort' => [
        'code' => 403,
        'message' => 'Unauthorised Access!',
    ],
];
