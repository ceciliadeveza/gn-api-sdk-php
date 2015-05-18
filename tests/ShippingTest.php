<?php

require_once __DIR__.'/Base.php';

class ShippingTest extends Base {

  public function testShipping() {
    $shipping = self::createShipping();

    $this->assertNotEmpty($shipping);
    $this->assertEquals($shipping->getPayeeCode(), 'jsadkbfwfzmndck');
    $this->assertEquals($shipping->getName(), 'Frete');
    $this->assertEquals($shipping->getValue(), 1575);
  }
}