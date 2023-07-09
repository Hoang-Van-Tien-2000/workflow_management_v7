<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'google' => [
        'client_id' => '287177563616-p2cbshoidkmarl802spo3f5tf81sqv2g.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8001/callback/google',
      ], 
      'github' => [

        'client_id' => '8e042bb2e883cade001a',
        'client_secret' => '49c1b271eda87eb988afcf5bbfebb90153aaa89b',
        'redirect' => 'http://127.0.0.1:8000/callback/github',
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
