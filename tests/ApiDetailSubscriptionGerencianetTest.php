<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiDetailSubscriptionGerencianetTest extends Base {

  public function testDetailSubscription() {
    $apiGN = self::createApiGN();

    $subscriptionId = 3;

    $detailSubscription = $apiGN->detailSubscription()
                                ->subscriptionId($subscriptionId);

    $this->assertNotEmpty($detailSubscription);
    $this->assertEquals($detailSubscription->getSubscriptionId(), 3);
  }

  public function testExecutedDetailSubscription() {
    $apiGN = self::createApiGN();

    $subscriptionId = 3;

    $detailSubscription = $apiGN->detailSubscription()
                                ->subscriptionId($subscriptionId);

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('detailSubscription', 200)]);

    $clientGZ = $detailSubscription->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $detailSubscription->guzzleClient($clientGZ);

    $resp = $detailSubscription->run()
                               ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['subscription']);
    $this->assertEquals($resp['subscription']['id'], 3);
    $this->assertEquals($resp['subscription']['value'], 10000);
    $this->assertEquals($resp['subscription']['status'], 'done');
    $this->assertEquals($resp['subscription']['payment_method'], 'credit_card');
    $this->assertEquals($resp['subscription']['interval'], 1);
    $this->assertEquals($resp['subscription']['repeats'], 2);
    $this->assertEquals($resp['subscription']['processed_amount'], 2);
    $this->assertEquals($resp['subscription']['created_at'], '2015-04-09 11:32:03');
    $this->assertNotEmpty($resp['subscription']['history']);
    $this->assertEquals(count($resp['subscription']['history']), 2);
    $this->assertEquals($resp['subscription']['history'][1]['charge_id'], 7);
    $this->assertEquals($resp['subscription']['history'][1]['status'], 'paid');
    $this->assertEquals($resp['subscription']['history'][1]['created_at'], '2015-04-09 11:36:22');
  }
}