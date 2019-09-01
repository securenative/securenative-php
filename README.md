# SecureNative PHP

## Installation

## Configuration

```php

SecureNative::init($API_KEY, new SecureNativeOptions());
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
SecureNative::track(array(
    'eventType' => EventTypes::LOG_IN,
    'ip' => '137.74.169.241',
    'userAgent' => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)	',
    'user' => (object)[
        'id' => '556595',
        'name' => '',
        'email' => 'test@test.com'
    ]
));

or

$ver = SecureNative::verify(array(
    'eventType' => EventTypes::VERIFY,
    'ip' => '103.234.220.197',
    'userAgent' => 'Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Mobile/7B405',
    'user' => (object)[
        'id' => '12345',
        'name' => '',
        'email' => 'amit@phptest.com'
    ]
));
```

Middleware:

```php
$res = SecureNative::getMiddleware()->verifySignature();

```
