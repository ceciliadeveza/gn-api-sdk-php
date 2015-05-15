# SDK GERENCIANET FOR PHP #
Sdk for Gerencianet Pagamentos' API.

**:warning: This module is under development and is based on the new API that Gerencianet is about to release. It won't work in production by now.**

## Installation ##
```
$ command
```

## Usage ##
Require the module:

```php
require_once __DIR__ . '/your_directory/autoload.php';
```

All code must be within a try catch like this:

```php
try {
  /* code */
} catch(GerencianetException $e) {
  ApiBaseGerencianet::error($e);
} catch(Exception $ex) {
  ApiBaseGerencianet::error($ex);
}
```

Instantiate the module passing your apiKey, your apiSecret and if you want use sandbox, respectively:

```php
$apiKey = 'your_client_id';
$apiSecret = 'your_client_secret';

$apiGN = new Gerencianet($apiKey, $apiSecret, true);
```

### Creating charge ###

To create a new charge, you must create at least one item:

```php
$item = new ItemGerencianet();
$item->name('Item Gerencianet')
     ->value(5000) // The value must be a integer (ex.: R$ 50,00 = 5000)
     ->amount(2);

$response = $apiGN->createCharge()
                  ->addItem($item)
                  ->run()
                  ->response();
```

You have two options to add items in the charge:

* Add one item each time:

```php
$response = $apiGN->createCharge()
                  ->addItem($item)
                  ->run()
                  ->response();
```

* Add many items:

```php
$response = $apiGN->createCharge()
                  ->addItems([$item1, $item2])
                  ->run()
                  ->response();
```

The charge can also have shipping and metadata:

```
$shipping = new ShippingGerencianet();
$shipping->name('Frete')
         ->value(2500);

$metadata = new MetadataGerencianet();
$metadata->customId('MEUID')
         ->notificationUrl('http://localhost/teste.php');

$response = $apiGN->createCharge()
                  ->addItem($item)
                  ->addShipping($shipping)
                  ->metadata($metadata)
                  ->run()
                  ->response();
```

As the item, freight also has two ways to be added:

* Add one item each time:

```php
$response = $apiGN->createCharge()
                  ...
                  ->addShipping(shipping)
                  ->run()
                  ->response();
```

* Add many items:

```php
$response = $apiGN->createCharge()
                  ...
                  ->addShippings([$shipping1, $shipping2])
                  ->run()
                  ->response();
```

## Running tests ##
To run tests using php unit run the following command:

```php
php phpunit.phar -c tests/config.xml tests
```
