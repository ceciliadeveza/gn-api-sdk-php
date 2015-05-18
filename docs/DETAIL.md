## Detailing charge ##

To detail a charge, you can use:
```php
$response = $apiGN->detailCharge()
                  ->chargeId($chargeId)
                  ->run()
                  ->response();
```


## Detailing subscription ##
To detail a subscription, you can do this:
```php
$response = $apiGN->detailSubscription()
                  ->subscriptionId($subscriptionId)
                  ->run()
                  ->response();
```