<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | This option controls the route prefix for all RP package routes.
    | You can change this to match your application's routing structure.
    |
    */
    'route_prefix' => env('RP_ROUTE_PREFIX', 'rp'),

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify the user model class that should be
    | used by the RP package. By default, it uses Laravel's default User model.
    |
    */
    'user_model' => env('RP_USER_MODEL', \App\Models\User::class),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be applied to all RP package routes.
    | You can customize this array to match your application's needs.
    |
    */
    'middleware' => [
        'web',
        'auth',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permission Guard
    |--------------------------------------------------------------------------
    |
    | This option specifies which guard should be used for permission checks.
    | By default, it uses the 'web' guard.
    |
    */
    'guard' => env('RP_GUARD', 'web'),

    /*
    |--------------------------------------------------------------------------
    | Items Per Page
    |--------------------------------------------------------------------------
    |
    | This option controls how many items are displayed per page in the
    | listing views.
    |
    */
    'items_per_page' => env('RP_ITEMS_PER_PAGE', 15),
];

