<?php

use GuzzleHttp\Subscriber\Mock;

require_once __DIR__.'/Base.php';

class ApiNotificationGerencianetTest extends Base {

  public function testUpdateNotification() {
    $apiGN = self::createApiGN();

    $notification = $apiGN->getNotifications();

    $mock = new Mock([$this->getMockResponse('auth', 200), $this->getMockResponse('notification', 200)]);

    $clientGZ = $notification->getGuzzleClient();
    $clientGZ->getEmitter()->attach($mock);

    $notification->guzzleClient($clientGZ);

    $chargeId = 10000;

    $resp = $notification->notificationToken('notificationToken')
                         ->run()
                         ->response();

    $this->assertEquals($resp['code'], 200);
    $this->assertNotEmpty($resp['charge']);
    $this->assertEquals($resp['charge']['id'], 332);
    $this->assertEquals($resp['charge']['total'], 10000);
    $this->assertEquals($resp['charge']['status'], 'waiting approval');
    $this->assertEquals($resp['charge']['custom_id'], '');
    $this->assertEquals($resp['charge']['created_at'], '2015-03-23');
    $this->assertEquals(count($resp['charge']['history']), 2);
    $this->assertEquals($resp['charge']['history'][0]['status'], 'new');
    $this->assertEquals($resp['charge']['history'][0]['timestamp'], '2015-03-23 14:31:44');
    $this->assertEquals($resp['charge']['history'][1]['status'], 'waiting approval');
    $this->assertEquals($resp['charge']['history'][1]['timestamp'], '2015-03-23 14:36:58');
  }
}