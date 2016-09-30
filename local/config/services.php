    <?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
    'client_id' => '167806036983988',
    'client_secret' => '0504d49d14514413884528dfb8771e75',
    'redirect' => 'http://public-post.com/beta2/auth/facebook/callback',
    ],
    'twitter' => [
    'client_id' => '4Brwp141HrMdvEefCWwxtwQSa',
    'client_secret' => 'MJ9G5jvrP2YPxe9EjaNDsGBD9rPd2PIY8uPF8eLMY0PiwqJKL4',
    'redirect' => ' http://public-post.com/beta2/auth/twitter/callback',
    ],

];
