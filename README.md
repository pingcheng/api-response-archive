# api-response
[![Build Status](https://travis-ci.org/pingcheng/api-response.svg?branch=master)](https://travis-ci.org/pingcheng/api-response)
[![Coverage Status](https://coveralls.io/repos/github/pingcheng/api-response/badge.svg?branch=master)](https://coveralls.io/github/pingcheng/api-response?branch=master)

A simple PHP API helper to generate JSON or XML result

# Installation
```bash
composer require pingcheng/api-response
```

# Supproted format
| Format  | Support |
| ------------- | ------------- |
| Json  | ✅  |
| XML  | ✅  |

# Usage

## Basic
```php
use PingCheng\ApiResponse\ApiResponse;
​
echo ApiResponse::json()
    ->code(400)
    ->addProperty('message', [
        'your result has been accepted'
    ])
    ->data([
        'id' => '1234',
        'result' => 'accepted'
    ]);
```
The reuslt you would have
```json
{
  "code": 400,
  "status": "Bad Request",
  "data": {
    "id": "1234",
    "result": "accepted"
  },
  "message": [
    "your result has been accepted"
  ]
}
```

Or, if you want to have a XML result
```php
use PingCheng\ApiResponse\ApiResponse;
​
echo ApiResponse::xml()
    ->code(400)
    ->addProperty('message', [
        'your result has been accepted'
    ])
    ->data([
        'id' => '1234',
        'result' => 'accepted'
    ]);
```

the result you would have
```xml
<root>
  <code>400</code>
  <status>Bad Request</status>
  <data>
    <id>1234</id>
    <result>accepted</result>
  </data>
  <message>your result has been accepted</message>
</root>
```

## Property
- addProperty(name, value);
- removeProperty(name);

Basically, ApiReponse would auto add a status description to the result based on the status code, for example, if you add 200 code to the response, the api would automatically add a status of "OK!". If you need to modify it, please use this function to add it or remove it
```php
// for modify 
...
->status('the new status message')
...
    
// for remove it
...
->removeProperty('status')
...
```

## Headers control
- addHeader(name, value);
- removeHeader(name);
- removeAllHeaders();
