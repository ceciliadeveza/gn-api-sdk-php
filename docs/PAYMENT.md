## Creating payment ##

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