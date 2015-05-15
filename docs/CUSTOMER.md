## Associating a customer to a charge ##

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