# api-response
A simple PHP API helper to generate JSON or XML result


# Supproted format
| Format  | Support |
| ------------- | ------------- |
| Json  | ✅  |
| XML  | ✅  |

# Usage
 
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
    ])
    ->output();
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
    ])
    ->output();
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

If you need to remove a property added before, simple use
```php
...
->removeProperty('name')
...
```

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