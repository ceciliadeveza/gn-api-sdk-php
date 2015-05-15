## Getting installments and total bol ##

To get the installments for a card brand, use:
```php
$response = $apiGN->getInstallments()
                  ->brand('mastercard')
                  ->value(10000)
                  ->run()
                  ->response();
```

Or if you want to get the total bol, use:
```php
$response = $apiGN->getTotalBol()
                  ->value(10000)
                  ->run()
                  ->response();
```