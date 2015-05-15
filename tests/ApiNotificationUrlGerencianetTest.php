<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiNotificationUrlGerencianetTest extends Base {

  public function testUpdateNotificationUrl() {
    $apiGN = self::createApiGN();

    $notificationUrl = $apiGN->updateNotificationUrl();

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('updateNotification', 200)]);

    $clientGZ = $notificationUrl->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $notificationUrl->guzzleClient($clientGZ);

    $chargeId = 10000;

    $resp = $notificationUrl->chargeId($chargeId)
                            ->notificationUrl('http://google.com.br')
                            ->run()
                            ->response();

    $this->assertEquals($resp['code'], 200);
  }
}