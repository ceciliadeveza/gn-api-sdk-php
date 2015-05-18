<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Gerencianet\Gerencianet;
use Gerencianet\Models\Address;
use Gerencianet\Models\Customer;
use Gerencianet\Models\GerencianetException;
use Gerencianet\Models\Item;
use Gerencianet\Models\Marketplace;
use Gerencianet\Models\Metadata;
use Gerencianet\Models\Repass;
use Gerencianet\Models\Shipping;
use Gerencianet\Models\Subscription;
use Gerencianet\Webservices\ApiBase;

echo 'SDK GN API';
echo '<pre>';

$apiKey = 'your_client_id';
$apiSecret = 'your_client_secret';

try {
  $apiGN = new Gerencianet($apiKey, $apiSecret, true);

  $repass = new Repass();
  $repass->payeeCode('payee_code_to_repass')
         ->percentage(700);

  $mkp = new Marketplace();
  $mkp->addRepass($repass);

  $item1 = new Item();
  $item1->name('Item 1')
        ->value(500)
        ->amount(2)
        ->marketplace($mkp);

  $item2 = new Item();
  $item2->name('Item 2')
        ->value(1000);

  $address = new Address();
  $address->street('Street 3')
          ->number('10')
          ->neighborhood('Bauxita')
          ->zipcode('35400000')
          ->city('Ouro Preto')
          ->state('MG');

  $customer = new Customer();
  $customer->name('Gorbadoc Oldbuck')
           ->email('oldbuck@gerencianet.com.br')
           ->document('04267484171')
           ->birth('1977-01-15')
           ->phoneNumber('5044916523')
           ->address($address);

  $metadata = new Metadata();
  $metadata->customId('MyID')
           ->notificationUrl('http://your_domain/your_notification_url');

  $metadata2 = new Metadata();
  $metadata2->customId('MyID2')
            ->notificationUrl('http://your_domain/your_notification_url');

  $shipping1 = new Shipping();
  $shipping1->payeeCode('payee_code_to_repass')
            ->name('Shipping')
            ->value(1575);

  $shipping2 = new Shipping();
  $shipping2->payeeCode('payee_code_to_repass')
            ->name('Shipping 2')
            ->value(2000);

  $shipping3 = new Shipping();
  $shipping3->name('Shipping 3')
            ->value(2500);

  $subscription = new Subscription();
  $subscription->repeats(2)
               ->interval(1);

  echo '</br>Installments for Mastercard:</br>';
  $respPaymentMethodsCard = $apiGN->getInstallments()
                                  ->brand('mastercard')
                                  ->value(10000)
                                  ->run()
                                  ->response();
  print_r($respPaymentMethodsCard);


  echo '</br>Total bol:</br>';
  $respPaymentMethodsBol = $apiGN->getTotalBol()
                                 ->value(10000)
                                 ->run()
                                 ->response();
  print_r($respPaymentMethodsBol);


  echo '</br>Charge (bol):</br>';
  $respCharge = $apiGN->createCharge()
                      ->addItem($item1)
                      ->addItem($item2)
                      ->addShipping($shipping1)
                      ->addShipping($shipping2)
                      ->metadata($metadata)
                      ->run()
                      ->response();
  print_r($respCharge);
  $chargeId = $respCharge['charge']['id'];


  echo '</br>Associating customer to a charge:</br>';
  $respCustomer = $apiGN->createCustomer()
                        ->chargeId($chargeId)
                        ->customer($customer)
                        ->run()
                        ->response();
  print_r($respCustomer);


  echo '</br>Paying with bol:</br>';
  $respPayment = $apiGN->createPayment()
                       ->chargeId($chargeId)
                       ->method('bol')
                       ->expireAt('2015-12-31')
                       ->run()
                       ->response();
  print_r($respPayment);


  echo '</br>Detailing a charge:</br>';
  $respDetailCharge = $apiGN->detailCharge()
                            ->chargeId($chargeId)
                            ->run()
                            ->response();
  print_r($respDetailCharge);


  echo '</br>Charge (credit card):</br>';
  $respCharge2 = $apiGN->createCharge()
                       ->addItems([$item1, $item2])
                       ->addShippings([$shipping1, $shipping2])
                       ->metadata($metadata2)
                       ->customer($customer)
                       ->run()
                       ->response();
  print_r($respCharge2);
  $chargeId2 = $respCharge2['charge']['id'];
  $paymentToken = 'payment_token';


  echo '</br>Paying with credit card:</br>';
  $respPayment2 = $apiGN->createPayment()
                        ->chargeId($chargeId2)
                        ->method('credit_card')
                        ->installments(3)
                        ->paymentToken($paymentToken)
                        ->billingAddress($address)
                        ->run()
                        ->response();
  print_r($respPayment2);


  echo '</br>Subscription:</br>';
  $respSubscription = $apiGN->createCharge()
                            ->addItem($item1)
                            ->addShipping($shipping3)
                            ->subscription($subscription)
                            ->customer($customer)
                            ->run()
                            ->response();
  print_r($respSubscription);
  $chargeId3 = $respSubscription['charge']['id'];
  $subscriptionId = $respSubscription['charge']['subscription_id'];


  echo '</br>Paying subscription:</br>';
  $respPaymentSubscription = $apiGN->createPayment()
                                   ->chargeId($chargeId3)
                                   ->method('credit_card')
                                   ->paymentToken($paymentToken)
                                   ->billingAddress($address)
                                   ->run()
                                   ->response();
  print_r($respPaymentSubscription);


  echo '</br>Update notification URL:</br>';
  $respUpdateNotification = $apiGN->updateNotificationUrl()
                                  ->notificationUrl('http://your_domain/your_new_notification_url')
                                  ->chargeId($chargeId2)
                                  ->run()
                                  ->response();
  print_r($respUpdateNotification);


  echo '</br>Notification:</br>';
  $notificationToken = 'notification_token';
  $respNotification = $apiGN->getNotifications()
                            ->notificationToken($notificationToken)
                            ->run()
                            ->response();
  print_r($respNotification);


  echo '</br>Detailing subscription:</br>';
  $respDetailSubscription = $apiGN->detailSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->run()
                                  ->response();
  print_r($respDetailSubscription);


  echo '</br>Canceling subscription:</br>';
  $respCancelSubscription = $apiGN->cancelSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->isCustomer(true)
                                  ->run()
                                  ->response();
  print_r($respCancelSubscription);

} catch(GerencianetException $e) {
  Gerencianet::error($e);
} catch(Exception $ex) {
  Gerencianet::error($ex);
}