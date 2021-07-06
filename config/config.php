<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'dry' => env('SMS_DRY', true),
    'provider' => env('SMS_PROVIDER', 'custom'),

    'endpoint' => env('SMS_ENDPOINT'),
    'method' => env('SMS_METHOD','get'),

    'username' => env('SMS_USERNAME',false),
    'username_param' =>  env('SMS_USER_PARAM','username'),

    'password' => env('SMS_PASSWORD',false),
    'password_param' =>  env('SMS_PASS_PARAM','password'),

    'from' => env('SMS_FROM',''),
    'from_param' => env('SMS_FROM_PARAM','from'),

    'to_param' => env('SMS_TO_PARAM','to'),
    'message_param' => env('SMS_MESSAGE_PARAM','message'),

    'authorization' => env('SMS_AUTH',false),
];