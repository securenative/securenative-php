<p align="center">
  <a href="https://www.securenative.com"><img src="https://user-images.githubusercontent.com/45174009/77826512-f023ed80-7120-11ea-80e0-58aacde0a84e.png" alt="SecureNative Logo"/></a>
</p>

<p align="center">
  <b>A Cloud-Native Security Monitoring and Protection for Modern Applications</b>
</p>
<p align="center">
  <a href="https://github.com/securenative/securenative-php">
    <img alt="Github Actions" src="https://github.com/securenative/securenative-php/workflows/CI/badge.svg">
  </a>
  <a href="https://codecov.io/gh/securenative/securenative-php">
    <img src="https://codecov.io/gh/securenative/securenative-php/branch/master/graph/badge.svg" />
  </a>
  <a href="https://packagist.org/packages/securenative/securenative-php">
  <img src="https://img.shields.io/packagist/v/securenative/securenative-php" alt="npm version" height="20">
    </a>
</p>
<p align="center">
  <a href="https://docs.securenative.com">Documentation</a> |
  <a href="https://docs.securenative.com/quick-start">Quick Start</a> |
  <a href="https://blog.securenative.com">Blog</a> |
  <a href="">Chat with us on Slack!</a>
</p>
<hr/>


[SecureNative](https://www.securenative.com/) performs user monitoring by analyzing user interactions with your application and various factors such as network, devices, locations and access patterns to stop and prevent account takeover attacks.

## Install the SDK

When using Composer run the following command:
```shell script
$ composer require securenative/securenative-php
```

## Initialize the SDK

To get your *API KEY*, login to your SecureNative account and go to project settings page:

### Option 1: Initialize via ConfigurationBuilder
```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeOptions;

$options =  new SecureNativeOptions();

$options->setMaxEvents(10);
$options->setLogLevel("error");

SecureNative::init("YOUR_API_KEY", $options);
```
### Option 2: Initialize via API Key

Initialize using default options.

```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;


SecureNative::init("YOUR_API_KEY");
```

## Tracking events

Once the SDK has been initialized, tracking requests sent through the SDK
instance.

```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeOptions;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNativeContext;

$clientToken = "SECURED_CLIENT_TOKEN"
$headers = (object)["user-agent" => "Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us"] // User-Agent header is important to get device information!
$ip = "127.0.0.1"
$remoteIp = "127.0.0.1"
$url = null
$method = null
$body = null
$ctx = new SecureNativeContext($clientToken, $ip, $remoteIp, $headers, $url, $method, $body);

SecureNative::track(array(
    'event' => EventTypes::LOG_IN,
    'context' => $ctx,
    'userId' => '1234',
    'userTraits' => (object)[
        'name' => 'Your Name',
        'email' => 'name@gmail.com'
    ],
    // Custom properties
    'properties' => (object)[
        "custom_param1" => "CUSTOM_PARAM_VALUE",
        "custom_param2" => true,
        "custom_param3" => 3
    ]
));
 ```

 ```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNativeContext;


SecureNative::track(array(
    'event' => EventTypes::LOG_IN,
    'context' => SecureNative::contextFromContext(),
    'userId' => '1234',
    'userTraits' => (object)[
        'name' => 'Your Name',
        'email' => 'name@gmail.com'
    ],
    // Custom properties
    'properties' => (object)[
        "custom_param1" => "CUSTOM_PARAM_VALUE",
        "custom_param2" => true,
        "custom_param3" => 3
    ]
));
 ```

You can also create request context from request:

```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNativeContext;


SecureNative::track(array(
    'event' => EventTypes::LOG_IN,
    'context' => SecureNativeContext::fromRequest(),
    'userId' => '1234',
    'userTraits' => (object)[
        'name' => 'Your Name',
        'email' => 'name@gmail.com'
    ],
));
```

## Verify events

**Example**

```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNativeContext;


$ver = SecureNative::verify(array(
        'event' => EventTypes::VERIFY,
        'userId' => '1234',
        'context' => SecureNativeContext::fromRequest(),
        'userTraits' => (object)[
            'name' => 'Your Name',
            'email' => 'name@gmail.com'
        ]
));

$ver.riskLevel    // Low, Medium, High
$ver.score        // Risk score: 0 - 1 (0 - Very Low, 1 - Very High)
$ver.triggers     // ["TOR", "New IP", "New City"]
```

## Webhook signature verification

Apply our filter to verify the request is from us, for example:

```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;


$verified = SecureNative::getMiddleware()->verifySignature();

if ($verified) {
    // Request is trusted (coming from SecureNative) 
}
 ```
