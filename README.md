# SecureNative PHP

## Requirements

* PHP version >= 7.2
* Composer

## Installation using composer

```shell script
$ composer require securenative/securenative-php
```

## Configuration

#### Using package
```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeOptions;
use SecureNative\sdk\EventTypes;
```

#### Initializing SDK

```php
SecureNative::init("YOUR_API_KEY", new SecureNativeOptions());
```

| Option | Type | Optional | Default Value | Description |
| -------| -------| -------| -------| -------------------------------------------------|
| apiKey | string | false | none | SecureNative api key |
| apiUrl | string | true | https://api.securenative.com/v1/collector | Default api base address|
| interval| number | true | 1000 | Default interval for SDK to try to persist events|  
| maxEvents | number | true | 1000 | Max in-memory events queue| 
| timeout | number | true | 1500 | API call timeout in ms|
| autoSend | Boolean | true | true | Should api auto send the events|

## Event tracking

```
$context = SecureNative::contextFromContext();

SecureNative::track(array(
    'event' => EventTypes::LOG_IN,
    'context' => $context,
    'userId' => '556595',
    'userTraits' => (object)[
        'name' => 'Your name',
        'email' => 'test@test.com'
    ],
    // Custom properties
    'properties' => (object)[
        "prop1" => "test",
        "prop2" => 3
    ]
));

or

$ver = SecureNative::verify(array(
    'event' => EventTypes::VERIFY,
    'context' => SecureNative::contextFromContext()
    'userTraits' => (object)[
        'name' => 'Your name',
        'email' => 'amit@phptest.com'
    ]
));
```

Middleware:

```php
$verified = SecureNative::getMiddleware()->verifySignature();

if ($verified) {
    // Request is trusted (coming from SecureNative) 
}
```
