## Notification ##

Notifications for a charge will be received at the notification URL sent in metadata. To detail this notification you must send the token received in your POST variable as listed below:
```php
$notificationToken = $_POST['notification'];
$response = $apiGN->getNotifications()
                  ->notificationToken($notificationToken)
                  ->run()
                  ->response();
```

If you want to change the notification URL of a charge, do as follow:
```php
$response = $apiGN->updateNotificationUrl()
                  ->notificationUrl('http://your_domain/your_new_notification_url')
                  ->chargeId($chargeId)
                  ->run()
                  ->response();
```