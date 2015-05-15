# SDK GERENCIANET FOR PHP #
Sdk for Gerencianet Pagamentos' API.
For more informations about parameters and values, please refer to [Gerencianet](http://gerencianet.com.br) documentation.

**:warning: This module is under development and is based on the new API that Gerencianet is about to release. It won't work in production by now.**


[![Build Status](https://travis-ci.org/talitacampos/gn-api-sdk-php.svg?branch=master)](https://travis-ci.org/talitacampos/gn-api-sdk-php)


## Installation ##
```
$ php composer.phar require gerencianet/gerencianet-sdk-php
```

## Get start ##
Require the module and namespaces:
```php
require __DIR__ . '/../sdk/vendor/autoload.php';

use Gerencianet\Gerencianet;
use Gerencianet\Webservices\ApiBaseGerencianet;
use Gerencianet\Helpers\AddressGerencianet;
use Gerencianet\Helpers\CustomerGerencianet;
use Gerencianet\Helpers\ItemGerencianet;
use Gerencianet\Helpers\MarketplaceGerencianet;
use Gerencianet\Helpers\MetadataGerencianet;
use Gerencianet\Helpers\RepassGerencianet;
use Gerencianet\Helpers\ShippingGerencianet;
use Gerencianet\Helpers\SubscriptionGerencianet;
```

All code must be within a try-catch like this:
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

## Creating charge ##

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

* Add one item at a time:
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

Charge can also have shipping and metadata:
```php
$shipping = new ShippingGerencianet();
$shipping->name('Shipping')
         ->value(2500);

$metadata = new MetadataGerencianet();
$metadata->customId('MyID')
         ->notificationUrl('http://your_domain/your_notification_url');

$response = $apiGN->createCharge()
                  ...
                  ->addShipping($shipping)
                  ->metadata($metadata)
                  ->run()
                  ->response();
```

As the item, shipping also has two ways to be added:

* Add one shipping at a time:
```php
$response = $apiGN->createCharge()
                  ...
                  ->addShipping($shipping)
                  ->run()
                  ->response();
```

* Add many shippings:
```php
$response = $apiGN->createCharge()
                  ...
                  ->addShippings([$shipping1, $shipping2])
                  ->run()
                  ->response();
```

## Running tests ##

To run tests install [PHPUnit](https://phpunit.de/getting-started.html) and run the following command:
```php
$ phpunit -c tests/config.xml tests
```

## Additional docs ##

- [Associating a customer to a charge](/docs/CUSTOMER.md)
- [Subscriptions](/docs/SUBSCRIPTION.md)
- [Detailing charge and subscriptions](/docs/DETAIL.md)
- [Creating payment](/docs/PAYMENT.md)
- [Notification](/docs/NOTIFICATION.md)
- [Marketplace](/docs/MARKETPLACE.md)
- [Getting installments and total bol](/docs/EXTRA.md)

## License ##
- [MIT](LICENSE)