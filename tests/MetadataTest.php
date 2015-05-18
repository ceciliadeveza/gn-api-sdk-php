<?php

require_once __DIR__.'/Base.php';

class MetadataTest extends Base {

  public function testMetadata() {
    $metadata = self::createMetadata();

    $this->assertNotEmpty($metadata);
    $this->assertEquals($metadata->getCustomId(), 'MYID');
    $this->assertEquals($metadata->getNotificationUrl(), 'http://localhost/teste.php');
  }
}