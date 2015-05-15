<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiDetailChargeGerencianetTest extends Base {

  public function testDetailCharge() {
    $apiGN = self::createApiGN();

    $chargeId = 6;

    $detailCharge = $apiGN->detailCharge()
                          ->chargeId($chargeId);

    $this->assertNotEmpty($detailCharge);
    $this->assertEquals($detailCharge->getchargeId(), 6);
  }

  public function testExecutedDetailCharge() {
    $apiGN = self::createApiGN();

    $chargeId = 6;

    $detailCharge = $apiGN->detailCharge()
                          ->chargeId($chargeId);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('detailCharge', 200)]);

    $clientGZ = $detailCharge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $detailCharge->guzzleClient($clientGZ);

    $resp = $detailCharge->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['charge']);
    $this->assertEquals($resp['charge']['id'], 6);
    $this->assertEquals($resp['charge']['subscription_id'], 3);
    $this->assertEquals($resp['charge']['total'], 10000);
    $this->assertEquals($resp['charge']['status'], 'waiting approval');
    $this->assertEquals($resp['charge']['created_at'], '2015-04-09');
    $this->assertEquals($resp['charge']['custom_id'], null);
    $this->assertEquals($resp['charge']['notification_url'], 'http://localhost/teste.php');
    $this->assertNotEmpty($resp['charge']['items']);
    $this->assertEquals(count($resp['charge']['items']), 1);
    $this->assertEquals($resp['charge']['items'][0]['name'], 'item 1');
    $this->assertEquals($resp['charge']['items'][0]['value'], 10000);
    $this->assertEquals($resp['charge']['items'][0]['amount'], 1);
    $this->assertNotEmpty($resp['charge']['history']);
    $this->assertEquals(count($resp['charge']['history']), 2);
    $this->assertEquals($resp['charge']['history'][1]['status'], 'waiting approval');
    $this->assertEquals($resp['charge']['history'][1]['created_at'], '2015-04-09 11:32:11');
    $this->assertNotEmpty($resp['charge']['customer']);
    $this->assertEquals($resp['charge']['customer']['name'], 'Gerencianet Pagamentos do Brasil');
    $this->assertEquals($resp['charge']['customer']['email'], 'suporte@gerencianet.com.br');
    $this->assertEquals($resp['charge']['customer']['document'], '26245144000100');
    $this->assertEquals($resp['charge']['customer']['birth'], '1995-05-02');
    $this->assertEquals($resp['charge']['customer']['phone_number'], '3136030800');
    $this->assertNotEmpty($resp['charge']['payment']);
    $this->assertEquals($resp['charge']['payment']['method'], 'credit_card');
    $this->assertEquals($resp['charge']['payment']['created_at'], '2015-04-09');
    $this->assertNotEmpty($resp['charge']['payment']['credit_card']);
    $this->assertEquals($resp['charge']['payment']['credit_card']['mask'], 'XXXXXXXXXXXX3335');
    $this->assertEquals($resp['charge']['payment']['credit_card']['installments'], 1);
    $this->assertEquals($resp['charge']['payment']['credit_card']['installment_value'], 0);
    $this->assertNotEmpty($resp['charge']['payment']['credit_card']['address']);
    $this->assertEquals($resp['charge']['payment']['credit_card']['address']['street'], 'Av. JK');
    $this->assertEquals($resp['charge']['payment']['credit_card']['address']['number'], 909);
    $this->assertEquals($resp['charge']['payment']['credit_card']['address']['complement'], null);
    $this->assertEquals($resp['charge']['payment']['credit_card']['address']['neighborhood'], 'Bauxita');
    $this->assertEquals($resp['charge']['payment']['credit_card']['address']['city'], 'Ouro Preto');
    $this->assertEquals($resp['charge']['payment']['credit_card']['address']['state'], 'MG');
    $this->assertEquals($resp['charge']['payment']['credit_card']['address']['zipcode'], '35400000');
  }
}