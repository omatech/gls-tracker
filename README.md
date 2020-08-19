# GLS-tracker

Get information from the XML webservices of ASMRED to track parcels

## Usage

### Get status information of an expedition
```
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
$uid_cliente='6BAB7A53-3B6D-4D5A-9450-xxxxxxx';                   // Unique code of the customer, you must ask your GLS representative for that code
$webservice_url='https://wsclientes.asmred.com/b2b.asmx?wsdl';    // URL of the webservice of asmred (GLS in Spain)
$code='86387468743';                                              // Expedition code

$gls_tracker=new GLSTracker($uid_cliente, $webservice_url);       // Create a new gls_tracker object initialized with the UID of the client and the webservice url
$result=$gls_tracker->getClientExpedition($code);                 // Get the expedition info of that code
if (!$result) die('Error getting expedition');                    // If there's an error getClientExpedition returns false

$first_expedition=$gls_tracker->expediciones[0];                  // Get first expedition info
print_r($first_expedition);                                       // Show expedition info
```

## Testing
Run all tests using 

```
vendor\bin\phpunit
```


