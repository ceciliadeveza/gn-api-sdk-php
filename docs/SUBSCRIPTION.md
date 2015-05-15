## Subscriptions ##

To create a charge as a subscription, you need add to charge creation the following code:
```php
$subscription = new SubscriptionGerencianet();
$subscription->repeats(2)
             ->interval(1);

$response = $apiGN->createCharge()
                  ...
                  ->subscription($subscription)
                  ->run()
                  ->response();
```

To cancel a subscription:
```php
$response = $apiGN->cancelSubscription()
                  ->subscriptionId($subscriptionId)
                  ->isCustomer(true) // This is optional
                  ->run()
                  ->response();
```