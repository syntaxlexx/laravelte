<?php

use App\Models\Configuration;

return [
    'restrict_non_admin_users_to_login_via_mobile_app' => [
        'description' => 'Restrict Non-Admin users to login only via mobile app',
        'type' => Configuration::TYPE_BOOL,
        'default' => false,
    ],

    'allow_users_to_update_email_address' => [
        'description' => 'Allow users to update their email address',
        'type' => Configuration::TYPE_BOOL,
        'default' => false,
    ],

    'add_sudo_to_admin_group' => [
        'description' => 'Add Superadmins/Developers to admin group? (They will also get admin notifications)',
        'type' => Configuration::TYPE_BOOL,
        'default' => true,
    ],

    'allow_user_registrations' => [
        'description' => 'Enable new users to register in the system',
        'type' => Configuration::TYPE_BOOL,
        'default' => true,
    ],

    'allow_user_reset_password' => [
        'description' => 'Enable new users to reset their passwords in the system',
        'type' => Configuration::TYPE_BOOL,
        'default' => true,
    ],

    'restrict_users_to_register_via_mobile_app' => [
        'description' => 'Restrict users to register only via mobile app',
        'type' => Configuration::TYPE_BOOL,
        'default' => false,
    ],

    'preferred_currency' => [
        'description' => 'The preferred currency to use in the system',
        'type' => Configuration::TYPE_TEXT,
        'default' => 'KES',
    ],

    'invoice_prefix' => [
        'description' => 'The Invoice Number Prefix',
        'type' => Configuration::TYPE_TEXT,
        'default' => "INV",
    ],

    'order_prefix' => [
        'description' => 'The Order Number Prefix',
        'type' => Configuration::TYPE_TEXT,
        'default' => "ORD",
    ],

    'otp_size' => [
        'description' => 'The size of the OTP number',
        'type' => Configuration::TYPE_NUMBER,
        'default' => 6,
    ],

    'otp_expiry_minutes' => [
        'description' => 'The expiry time in minutes of the OTP number',
        'type' => Configuration::TYPE_NUMBER,
        'default' => 10,
    ],
];
