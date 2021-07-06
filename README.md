# Laravel Bulk SMS (HTTP API)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bluedot/laravel-bulk-sms.svg?style=flat-square)](https://packagist.org/packages/bluedot/laravel-bulk-sms)
[![Total Downloads](https://img.shields.io/packagist/dt/bluedot/laravel-bulk-sms.svg?style=flat-square)](https://packagist.org/packages/bluedot/laravel-bulk-sms)
![GitHub Actions](https://github.com/bluedot/laravel-bulk-sms/actions/workflows/main.yml/badge.svg)

A simple Bulk SMS (HTTP API) for Laravel (with notification support). 

## Installation

You can install the package via composer:

```bash
composer require bluedot/laravel-bulk-sms
```

add followings in `.env` :<br>
if your provider use OAuth, API Key, JWT Token or any Header based authentication, use followings
```
SMS_DRY=true
SMS_AUTH=""
SMS_ENDPOINT=""
SMS_METHOD=""
SMS_FROM=""
SMS_FROM_PARAM=""
SMS_TO_PARAM=""
SMS_MESSAGE_PARAM=""
```

If your provider use username and password for authentication, use followings
```
SMS_DRY=true
SMS_ENDPOINT=""
SMS_METHOD=""
SMS_USERNAME=""
SMS_USER_PARAM=""
SMS_PASSWORD=""
SMS_PASS_PARAM=""
SMS_FROM=""
SMS_FROM_PARAM=""
SMS_TO_PARAM=""
SMS_MESSAGE_PARAM=""
```

| `.env` VARIABLE  | TYPE  |  REQUIRED | DETAILS  |
|---|---|---|---|
| SMS_DRY | bool | yes | if value equals `true` sms is written in `larave.log` file, if false sms send using http api |
| SMS_AUTH | string | yes/no | for Header based authentication (OAuth, API Key, JWT Token) |
| SMS_ENDPOINT | string | yes | providers sms sending endpoint |
| SMS_METHOD | string | no | Set request method (get/post) |
| SMS_USERNAME | string | yes/no | use sms providers username or email (your account) |
| SMS_USER_PARAM | string | yes | sms providers parameter for username |
| SMS_PASSWORD | string | yes/no | use sms providers password (your account) |
| SMS_PASS_PARAM | string | yes | sms providers parameter for password |
| SMS_FROM | string | yes | sm ssenders address (leave empty if provider has none) |
| SMS_FROM_PARAM | string | yes | sms providers parameter for sender |
| SMS_TO_PARAM | string | yes | sms providers parameter for recipient |
| SMS_MESSAGE_PARAM | string | yes | sms providers parameter for message / text body |


## Usage

You can use it in Notification:
```php
use LaravelBulkSms;
use Bluedot\LaravelBulkSms\SmsChannel;

public function via($notifiable)
{
    return [SmsChannel::class];
}

/**
 * Get the sms representation of the notification.
 *
 * @param  mixed  $notifiable
 */
public function toSms($notifiable)
{
    return (new LaravelBulkSms)
        ->to()
        ->line();
}
```

or you can use it directly:
```php
use LaravelBulkSms;
$sms = new LaravelBulkSms();
$sms->to('01xxxx')->from('01xxxx')->message('Your SMS Text')->send();
```

### Security

If you discover any security related issues, please email me@saiful.im instead of using the issue tracker.

## Credits

-   [Saiful Islam](https://github.com/saaiful)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
