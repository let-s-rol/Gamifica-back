<?php

return [

/*
|--------------------------------------------------------------------------
| Authentication Defaults
|--------------------------------------------------------------------------
|
| This option controls the default authentication "guard" and password
| reset options for your application. You may change these defaults
| as required, but they're a perfect start for most applications.
|
*/

'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],

/*
|--------------------------------------------------------------------------
| Authentication Guards
|--------------------------------------------------------------------------
|
| Next, you may define every authentication guard for your application.
| Of course, a great default configuration has been defined for you
| here which uses session storage and the Eloquent user provider.
|
| All authentication drivers have a user provider. This defines how the
| users are actually retrieved out of your database or other storage
| mechanisms used by this application to persist your user's data.
|
| Supported: "session", "token"
|
*/

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],

/*
|--------------------------------------------------------------------------
| User Providers
|--------------------------------------------------------------------------
|
| All authentication drivers have a user provider. This defines how the
| users are actually retrieved out of your database or other storage
| mechanisms used by this application to persist your user's data.
|
| If you have multiple user tables or models you may configure multiple
| sources which represent each model / table. These sources may then
| be assigned to any extra authentication guards you have defined.
|
| Supported: "database", "eloquent"
|
*/

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],

/*
|--------------------------------------------------------------------------
| Password Reset
|--------------------------------------------------------------------------
|
| Here you can specify the options related to password reset, such as the
| expire time for reset tokens and the email address to send the password
| reset notifications to. You can also customize the email notification
| template if needed.
|
*/

'passwords' => [
    'users' => [
        'provider' => 'users',
        'expire' => 60,
        'throttle' => 60,
        'email' => 'emails.password',
    ],
],

/*
|--------------------------------------------------------------------------
| JWT Configuration
|--------------------------------------------------------------------------
|
| This section is for configuring the JWT authentication library.
|
*/

'jwt' => [
    'secret' => env('JWT_SECRET'),
    'ttl' => env('JWT_TTL', 60),
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),
    'algo' => env('JWT_ALGO', 'HS256'),
],

/*
|--------------------------------------------------------------------------
| Password Confirmation Timeout
|--------------------------------------------------------------------------
|
| Here you may define the amount of seconds before a password confirmation
| times out and the user is prompted to re-enter their password via the
| confirmation screen. By default, the timeout lasts for three hours.
|
*/


    'password_timeout' => 10800,

];
