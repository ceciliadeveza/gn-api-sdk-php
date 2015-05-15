<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiChargeGerencianetTest extends Base {

  public function testCharge() {
    $charge = self::createCharge();

    $this->assertNotEmpty($charge);
    $this->assertNotEmpty($charge->getItems());
    $this->assertEquals(count($charge->getItems()), 3);
    $this->assertNotEmpty($charge->getShippings());
    $this->assertEquals(count($charge->getShippings()), 3);
    $this->assertNotEmpty($charge->getMetadata());
    $this->assertNotEmpty($charge->getSubscription());
  }

  public function testExecuteCharge() {
    $charge = self::createCharge();
    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('charge', 200)]);

    $clientGZ = $charge->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $charge->guzzleClient($clientGZ);

    $resp = $charge->run()
                   ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['charge']);
    $this->assertEquals($resp['charge']['id'], 10000);
    $this->assertEquals($resp['charge']['custom_id'], 'MYID');
  }
}