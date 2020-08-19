# GLS-tracker

Get information from the XML webservices of ASMRED to track parcels

## Usage

### Get status information of an expedition
```
use Omatech\GLSTracker\GLSTracker;

...

$uid_cliente='6BAB7A53-3B6D-4D5A-9450-xxxxxxx';                   // Unique code of the customer, you must ask your GLS representative for that code
$webservice_url='https://wsclientes.asmred.com/b2b.asmx?wsdl';    // URL of the webservice of asmred (GLS in Spain)
$code='86387468743';                                              // Expedition code

$gls_tracker=new GLSTracker($uid_cliente, $webservice_url);       // Create a new gls_tracker object initialized with the UID of the client and the webservice url
$result=$gls_tracker->getClientExpedition($code);                 // Get the expedition info of that code
if (!$result) die('Error getting expedition');                    // If there's an error getClientExpedition returns false

$status=$gls_tracker->getExpeditionStatus();                      // Get expedition status, possible values are GRABADO, EN REPARTO, ENTREGADO
```

### Get all the information of an expedition

```
use Omatech\GLSTracker\GLSTracker;

...

$uid_cliente='6BAB7A53-3B6D-4D5A-9450-xxxxxxx';                   // Unique code of the customer, you must ask your GLS representative for that code
$webservice_url='https://wsclientes.asmred.com/b2b.asmx?wsdl';    // URL of the webservice of asmred (GLS in Spain)
$code='86387468743';                                              // Expedition code

$gls_tracker=new GLSTracker($uid_cliente, $webservice_url);       // Create a new gls_tracker object initialized with the UID of the client and the webservice url
$result=$gls_tracker->getClientExpedition($code);                 // Get the expedition info of that code
if (!$result) die('Error getting expedition');                    // If there's an error getClientExpedition returns false

$first_expedition=$gls_tracker->expediciones[0];                  // Get first expedition info
print_r($first_expedition);                                       // Show expedition info
```

## Use it in a Laravel project

### Install a new Laravel project

```
laravel new laravel-gls-tracker-example
``` 

### Enter the project and add omatech/gls-tracker to it

```
cd laravel-gls-tracker-example
composer require omatech/gls-tracker
```

### Add environment variables in your .env file
```
GLS_WEBSERVICE_URL=https://wsclientes.asmred.com/b2b.asmx?wsdl
GLS_UID_CLIENTE=6BAB7A53-3B6D-4D5A-9450-xxxxxx
```

### Edit routes/web.php:

### Add use at the top

```
use Omatech\GLSTracker\GLSTracker;
```

### Replace the default route:

```
Route::get('/{code?}'
, function ($code='61771040949189') {                                 // Default expedition code
    $webservice_url=env('GLS_WEBSERVICE_URL');                        // URL of the webservice of asmred (GLS in Spain)
    $uid_cliente=env('GLS_UID_CLIENTE');                              // Unique code of the customer, you must ask your GLS representative for that code
    
    echo "url=$webservice_url uid=$uid_cliente code=$code<br>";  // DEBUG info
    $gls_tracker=new GLSTracker($uid_cliente, $webservice_url);       // Create a new gls_tracker object initialized with the UID of the client and the webservice url
    $result=$gls_tracker->getClientExpedition($code);                 // Get the expedition info of that code
    if (!$result) die('Error getting expedition');                    // If there's an error getClientExpedition returns false
    
    $first_expedition=$gls_tracker->expediciones[0];                  // Get first expedition info
    dd($first_expedition);                                       // Show expedition info
});
```

### Now you can visit your home url to get the expedition info, in my case
```
http://laravel-gls-tracker-example.test/
```

### or changing the default code
```
http://laravel-gls-tracker.test/61771040888151
```

## Testing
Run all tests using 

```
vendor\bin\phpunit
```


