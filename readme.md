
## How to

```git clone git@github.com:valeriabarros/safetyRatings.git```

```cd safetyRatings```

```composer install```

```php artisan serve```

Access the URL shown in the output, for example: `127.0.0.1:8000`

## Routes

POST /vehicles

  > payload example:
   ```javascript 
   {
      "modelYear": 2015,
      "manufacturer": "Toyota",
      "model": "Yaris"
    }
   ```
GET ```/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>```

GET ```/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=true```

## Follow up

[@barros_val](https://www.twitter.com/barros_val)
