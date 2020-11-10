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

### Add required imports
```php
require_once __DIR__ . '/vendor/autoload.php';

use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeOptions;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNativeContext;
```

## Initialize the SDK

To get your *API KEY*, login to your SecureNative account and go to project settings page:

### Option 1: Initialize via API_KEY and SecureNativeOptions
```php
$options = new SecureNativeOptions();
$options->setTimeout(100)
    ->setApiUrl("API URL")
    ->setDisable(false)
    ->setInterval(100)
    ->setAutoSend(true)
    ->setMaxEvents(10)
    ->setLogLevel('fatal');

// Passing `$options` is optional, will use default params
SecureNative::init("[API_KEY]", $options);
```
### Option 2: Initialize via configuration file

Attach `securenative.json` file to your root folder:

```json
{
  "SECURENATIVE_API_KEY": "YOUR_API_KEY",
  "SECURENATIVE_APP_NAME": "APP_NAME",
  "SECURENATIVE_API_URL": "API_URL",
  "SECURENATIVE_INTERVAL": 1000,
  "SECURENATIVE_MAX_EVENTS": 100,
  "SECURENATIVE_TIMEOUT": 1500,
  "SECURENATIVE_AUTO_SEND": true,
  "SECURENATIVE_DISABLE": false,
  "SECURENATIVE_LOG_LEVEL": "fatal"
}
```
Then, call SDK's `init` function without props (sending props will override JSON configurations).
```php
SecureNative::init();
```

### Option 3: Initialize via environment variables

Pass desired environment variables (for example):

```shell script
SECURENATIVE_API_KEY=TEST_KEY
SECURENATIVE_API_URL=http://url
SECURENATIVE_INTERVAL=100
SECURENATIVE_MAX_EVENTS=30
SECURENATIVE_TIMEOUT=1500
SECURENATIVE_AUTO_SEND=true
SECURENATIVE_DISABLE=false
SECURENATIVE_LOG_LEVEL=fatal
```

Then, call SDK's `init` function without props (sending props will override JSON configurations).
```php
SecureNative::init();
```

## Tracking events

Once the SDK has been initialized, tracking requests sent through the SDK
instance.

```php
$clientToken = "[SECURED_CLIENT_TOKEN]";
$headers = (object)["user-agent" => "Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us"];
$ip = "79.179.88.157";
$remoteIp = null;
$url = null;
$method = null;
$body = null;

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

You can also create request context from request:
 ```php
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

## Verify events

**Example**

```php
$options = new SecureNativeOptions();

$ver = SecureNative::verify(array(
    'event' => EventTypes::VERIFY,
    'userId' => '1234',
    'context' => SecureNative::fromRequest($options),
    'userTraits' => (object)[
        'name' => 'Your Name',
        'email' => 'name@gmail.com'
    ]
));

print_r($ver->riskLevel);   // (Low, Medium, High)
print_r($ver->score);       // (0 - Very Low, 1 - Very High)
print_r($ver->triggers);    // (Example: ["TOR", "New IP", "New City"])
```

## Webhook signature verification

Apply our filter to verify the request is from us, for example:

```php
$verified = SecureNative::getMiddleware()->verifySignature();

if ($verified) {
    // Request is trusted (coming from SecureNative) 
}
 ```

## Extract proxy headers from cloud providers

You can specify custom header keys to allow extraction of client ip from different providers.
This example demonstrates the usage of proxy headers for ip extraction from Cloudflare.

### Option 1: Using config file
```json
{
    "SECURENATIVE_API_KEY": "YOUR_API_KEY",
    "SECURENATIVE_PROXY_HEADERS": ["CF-Connecting-IP"]
}
```

Initialize sdk as shown above.

### Options 2: Using ConfigurationBuilder

```php
$options = new SecureNativeOptions();
$options->setProxyHeaders(["CF-Connecting-IP"]);

SecureNative::init();
``` 