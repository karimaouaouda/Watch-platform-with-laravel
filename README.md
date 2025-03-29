# API Documentation

## Check License Keys
**for now, when a user try to authenticate to our app, he should pass through
two scenarios :**

1 - when a user will enter the license key for the first time, 
in this case the user must provide a valid license key that never used before, in this case
the license key must not be associated with any device.

2 - the user already enter the license key before, in this case, the app developer automatically stored it locally in the device
just he must send it automatically to the server with the device id


the endpoint : 

```
https://kabos5.me/api/license/check
```

you must provide the `license key` and the `device id` :
```json
{
    "license_key" : "7A09B0BAED9A40BF96288B97B1CC66E8",
    "device_unique_id" : "<device_id>"
}
```

example success response ( the user can come in) :
```json
{
    "status" : "success",
    "message" : "License key is valid"
}
```

example of failure:
```json
{
    "status" : "error",
    "message" : "Invalid license key"
}
```
