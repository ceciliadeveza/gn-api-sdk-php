<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiPaymentMethodsTest extends Base {

  public function testPaymentMethodsBol() {
    $apiGN = self::createApiGN();

    $paymentMethod = $apiGN->getInstallments();

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('paymentMethodBol', 200)]);

    $clientGZ = $paymentMethod->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $paymentMethod->guzzleClient($clientGZ);

    $resp = $paymentMethod->value(10000)
                          ->run()
                          ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['method']);
    $this->assertEquals($resp['method']['total'], 10150);
    $this->assertEquals($resp['method']['rate'], 150);
    $this->assertEquals($resp['method']['currency'], '101,50');
  }

  public function testPaymentMethodsCreditCard() {
    $apiGN = self::createApiGN();

    $paymentMethod = $apiGN->getInstallments();

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('paymentMethodCreditCard', 200)]);

    $clientGZ = $paymentMethod->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $paymentMethod->guzzleClient($clientGZ);

    $resp = $paymentMethod->brand('mastercard')
                          ->value(10000)
                          ->run()
                          ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['method']);
    $this->assertEquals($resp['method']['rate'], 150);
    $this->assertEquals($resp['method']['interest_percentage'], 199);
    $this->assertEquals($resp['method']['name'], 'mastercard');
    $this->assertEquals(count($resp['method']['installments']), 12);
    $this->assertEquals($resp['method']['installments'][11]['installment'], 12);
    $this->assertEquals($resp['method']['installments'][11]['has_interest'], true);
    $this->assertEquals($resp['method']['installments'][11]['value'], 1072);
    $this->assertEquals($resp['method']['installments'][11]['currency'], '10,72');
  }
}