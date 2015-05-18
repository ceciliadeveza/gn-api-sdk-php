<?php

require_once __DIR__.'/Base.php';

class RepassTest extends Base {

  public function testRepass() {
    $repass = self::createRepass();

    $this->assertNotEmpty($repass);
    $this->assertEquals($repass->getPayeeCode(), 'jsadkbfwfzmndck');
    $this->assertEquals($repass->getPercentage(), 700);
  }
}