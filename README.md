# SecureNative PHP

## Installation

## Configuration

```php

$sn = new SecureNative('YOUR_API_KEY', new SecureNativeOptions());
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
secureNative::track(array(
    'event_type' => EventTypes::LOG_IN,
    'ip' => '127.0.0.1',
    'userAgent' => 'Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Mobile/7B405',
    'user' => (object)[
        'id' => '12345'
    ]
));

or

secureNative::track(array(
    EventOptions::EVENT_EVENT_TYPE => EventTypes::LOG_IN,
    EventOptions::EVENT_IP => '127.0.0.1',
    EventOptions::USER_AGENT => 'Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Mobile/7B405',
    EventOptions::USER=> (object)[
        'id' => '12345'
    ]
));
    
```
