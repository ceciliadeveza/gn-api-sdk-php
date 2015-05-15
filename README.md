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

### Associating a customer to a charge ###

You have two options to add a customer:

* Add a customer in the moment to create a charge:
```php
$address = new AddressGerencianet();
$address->street('Street 3')
        ->number('10')
        ->neighborhood('Bauxita')
        ->zipcode('35400000')
        ->city('Ouro Preto')
        ->state('MG');

$customer = new CustomerGerencianet();
$customer->name('Gorbadoc Oldbuck')
         ->email('oldbuck@gerencianet.com.br')
         ->document('04267484171')
         ->birth('1977-01-15')
         ->phoneNumber('5044916523')
         ->address($address); // This address is a shipping address and it is optional.

$response = $apiGN->createCharge()
                  ...
                  ->customer($customer)
                  ->run()
                  ->response();
```

* Add a customer after create a charge:
```php
$chargeId = ''; // The value returned by createCharge function
$response = $apiGN->createCustomer()
                  ->chargeId($chargeId)
                  ->customer($customer)
                  ->run()
                  ->response();
```

### Paying charge ###

To pay the charge you must use the createPayment function, but you must define if the payment method is **bol** or **credit card**.

* If the method is bol:
```php
$response = $apiGN->createPayment()
                  ->chargeId($chargeId)
                  ->method('bol')
                  ->expireAt('2015-12-31') // This date is optional
                  ->run()
                  ->response();
```

* If the method is credit card:
```php
$paymentToken = 'payment_token';
$response = $apiGN->createPayment()
                  ->chargeId($chargeId)
                  ->method('credit_card')
                  ->installments(3)
                  ->paymentToken($paymentToken)
                  ->billingAddress($address)
                  ->run()
                  ->response();
```

### Marketplace ###

If you want use marketplace, use as follow:

```php
$repass = new RepassGerencianet();
$repass->payeeCode('payee_code_to_repass')
       ->percentage(7000);

$mkp = new MarketplaceGerencianet();
$mkp->addRepass($repass);

$item = new ItemGerencianet();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->marketplace($mkp);
```

### Repassing the shipping ###

If you want send the shipping value to another Gerencianet account, you need the account payee code e must send so:
```php
$shipping->payeeCode('payee_code_to_repass')
         ->name('Shipping')
         ->value(2000);
```

### Detailing charge ###
To detail a charge, you can use:
```php
$response = $apiGN->detailCharge()
                  ->chargeId($chargeId)
                  ->run()
                  ->response();
```

## Running tests ##
To run tests using php unit run the following command:

```php
php phpunit.phar -c tests/config.xml tests
```
