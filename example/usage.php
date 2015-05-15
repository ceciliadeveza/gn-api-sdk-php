<?php

require_once __DIR__ . '/sdk/autoload.php';

echo 'SDK GN API';
echo '<pre>';

$apiKey = 'your_client_id';
$apiSecret = 'your_client_secret';

try {
  $apiGN = new Gerencianet($apiKey, $apiSecret, true);

  $repass = new RepassGerencianet();
  $repass->payeeCode('payee_code_to_repass')
         ->percentage(700);

  $mkp = new MarketplaceGerencianet();
  $mkp->addRepass($repass);

  $item1 = new ItemGerencianet();
  $item1->name('Item 1')
        ->value(500)
        ->amount(2)
        ->marketplace($mkp);

  $item2 = new ItemGerencianet();
  $item2->name('Item 2')
        ->value(1000);

  $address = new AddressGerencianet();
  $address->street('Av. JK')
          ->number('909')
          ->neighborhood('Bauxita')
          ->zipcode('35400000')
          ->city('Ouro Preto')
          ->state('MG');

  $customer = new CustomerGerencianet();
  $customer->name('Gerencianet Pagamentos do Brasil')
           ->email('suporte@gerencianet.com.br')
           ->document('26245144000100')
           ->birth('02/05/1995')
           ->phoneNumber('3136030800')
           ->address($address);

  $metadata = new MetadataGerencianet();
  $metadata->customId('MEUID')
           ->notificationUrl('http://localhost/teste.php');

  $metadata2 = new MetadataGerencianet();
  $metadata2->customId('MEUID2')
            ->notificationUrl('http://localhost/teste.php');

  $shipping1 = new ShippingGerencianet();
  $shipping1->payeeCode('payee_code_to_repass')
            ->name('Frete')
            ->value(1575);

  $shipping2 = new ShippingGerencianet();
  $shipping2->payeeCode('payee_code_to_repass')
            ->name('Frete 2')
            ->value(2000);

  $shipping3 = new ShippingGerencianet();
  $shipping3->name('Frete para Assinatura')
            ->value(2500);

  $subscription = new SubscriptionGerencianet();
  $subscription->repeats(2)
               ->interval(1);

  echo '</br>Parcelas para Mastercard:</br>';
  $respPaymentMethodsCard = $apiGN->getInstallments()
                                  ->brand('mastercard')
                                  ->value(10000)
                                  ->run()
                                  ->response();
  print_r($respPaymentMethodsCard);


  echo '</br>Valor de boleto:</br>';
  $respPaymentMethodsBol = $apiGN->getTotalBol()
                                 ->value(10000)
                                 ->run()
                                 ->response();
  print_r($respPaymentMethodsBol);


  echo '</br>Charge (boleto):</br>';
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


  echo '</br>Adiciona cliente para a charge:</br>';
  $respCustomer = $apiGN->createCustomer()
                        ->chargeId($chargeId)
                        ->customer($customer)
                        ->run()
                        ->response();
  print_r($respCustomer);


  echo '</br>Pagamento com boleto:</br>';
  $respPayment = $apiGN->createPayment()
                       ->chargeId($chargeId)
                       ->method('bol')
                       ->expireAt('2015-12-31')
                       ->run()
                       ->response();
  print_r($respPayment);


  echo '</br>Detalha charge:</br>';
  $respDetailCharge = $apiGN->detailCharge()
                            ->chargeId($chargeId)
                            ->run()
                            ->response();
  print_r($respDetailCharge);


  echo '</br>Charge (cartão):</br>';
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


  echo '</br>Pagamento com cartão:</br>';
  $respPayment2 = $apiGN->createPayment()
                        ->chargeId($chargeId2)
                        ->method('credit_card')
                        ->installments(3)
                        ->paymentToken($paymentToken)
                        ->billingAddress($address)
                        ->run()
                        ->response();
  print_r($respPayment2);


  echo '</br>Assinatura:</br>';
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


  echo '</br>Pagamento assinatura:</br>';
  $respPaymentSubscription = $apiGN->createPayment()
                                   ->chargeId($chargeId3)
                                   ->method('credit_card')
                                   ->paymentToken($paymentToken)
                                   ->billingAddress($address)
                                   ->run()
                                   ->response();
  print_r($respPaymentSubscription);


  echo '</br>Atualiza url de notificação da charge de cartão:</br>';
  $respUpdateNotification = $apiGN->updateNotificationUrl()
                                  ->notificationUrl('http://localhost/notification.php')
                                  ->chargeId($chargeId2)
                                  ->run()
                                  ->response();
  print_r($respUpdateNotification);


  echo '</br>Notificação:</br>';
  $notificationToken = 'notification_token';
  $respNotification = $apiGN->getNotifications()
                            ->notificationToken($notificationToken)
                            ->run()
                            ->response();
  print_r($respNotification);


  echo '</br>Detalha assinatura:</br>';
  $respDetailSubscription = $apiGN->detailSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->run()
                                  ->response();
  print_r($respDetailSubscription);


  echo '</br>Cancela assinatura:</br>';
  $respCancelSubscription = $apiGN->cancelSubscription()
                                  ->subscriptionId($subscriptionId)
                                  ->isCustomer(true)
                                  ->run()
                                  ->response();
  print_r($respCancelSubscription);

} catch(GerencianetException $e) {
  ApiBaseGerencianet::error($e);
} catch(Exception $ex) {
  ApiBaseGerencianet::error($ex);
}