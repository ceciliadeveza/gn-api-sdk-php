<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiPaymentTest extends Base {

  public function testPaymentBol() {
    $apiGN = self::createApiGN();

    $chargeId = 10000;

    $payment = $apiGN->createPayment();

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('bol', 200)]);

    $clientGZ = $payment->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $payment->guzzleClient($clientGZ);

    $resp = $payment->chargeId($chargeId)
                    ->method('bol')
                    ->expireAt('2015-12-31')
                    ->run()
                    ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['response']);
    $this->assertEquals($resp['response']['transaction'], 10000);
    $this->assertEquals($resp['response']['payment'], 'bol');
  }

  public function testPaymentCreditCard() {
    $apiGN = self::createApiGN();
    $address = self::createAddress();

    $chargeId = 10000;
    $paymentToken = 'payment_token';

    $payment = $apiGN->createPayment();

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('card', 200)]);

    $clientGZ = $payment->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $payment->guzzleClient($clientGZ);

    $resp = $payment->chargeId($chargeId)
                    ->method('credit_card')
                    ->installments(1)
                    ->paymentToken($paymentToken)
                    ->billingAddress($address)
                    ->run()
                    ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['response']);
    $this->assertEquals($resp['response']['transaction'], 10000);
    $this->assertEquals($resp['response']['payment'], 'credit_card');
  }
}