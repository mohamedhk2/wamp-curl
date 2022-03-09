# Wamp Curl Fix

[![Latest Stable Version](http://poser.pugx.org/mohamedhk2/wamp-curl/v)](https://packagist.org/packages/mohamedhk2/wamp-curl)
[![Total Downloads](http://poser.pugx.org/mohamedhk2/wamp-curl/downloads)](https://packagist.org/packages/mohamedhk2/wamp-curl)
[![Latest Unstable Version](http://poser.pugx.org/mohamedhk2/wamp-curl/v/unstable)](https://packagist.org/packages/mohamedhk2/wamp-curl)
[![License](http://poser.pugx.org/mohamedhk2/wamp-curl/license)](https://packagist.org/packages/mohamedhk2/wamp-curl)

## Install
The recommended way to install this is through composer:
```bashpro shell script
composer require mohamedhk2/wamp-curl
```

## Usage
- Download `cacert.pem` from `https://curl.haxx.se/ca/cacert.pem`
```php
require_once 'vendor/autoload.php';
$results = \Mohamedhk2\WampCurl\WampCurl::fix('C:\wamp64', 'C:\wamp64\bin\cacert.pem');
var_dump($results);
```

## License
Wamp Curl Fix is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)