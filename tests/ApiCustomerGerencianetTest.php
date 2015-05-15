<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiCustomerGerencianetTest extends Base {

  public function testCustomer() {
    $apiGN = self::createApiGN();
    $customerData = self::createCustomer();

    $chargeId = 10000;

    $customerToCharge = $apiGN->createCustomer()
                              ->chargeId($chargeId)
                              ->customer($customerData);

    $this->assertNotEmpty($customerToCharge);
    $this->assertEquals($customerToCharge->getChargeId(), 10000);
    $this->assertEquals($customerToCharge->getCustomer()->getName(), 'Gerencianet Pagamentos do Brasil');
    $this->assertEquals($customerToCharge->getCustomer()->getEmail(), 'suporte@gerencianet.com.br');
    $this->assertEquals($customerToCharge->getCustomer()->getDocument(), '26245144000100');
    $this->assertEquals($customerToCharge->getCustomer()->getBirth(), '1995-05-02');
    $this->assertEquals($customerToCharge->getCustomer()->getPhoneNumber(), '3136030800');
  }

  public function testExecuteCustomer() {
    $apiGN = self::createApiGN();
    $customerData = self::createCustomer();

    $chargeId = 10000;

    $customerToCharge = $apiGN->createCustomer()
                              ->chargeId($chargeId)
                              ->customer($customerData);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('response', 200)]);

    $clientGZ = $customerToCharge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $customerToCharge->guzzleClient($clientGZ);

    $resp = $customerToCharge->run()
                             ->response();

    $this->assertEquals($resp['code'], 200);
  }
}