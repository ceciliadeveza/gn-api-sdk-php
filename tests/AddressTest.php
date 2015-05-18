<?php

require_once __DIR__.'/Base.php';

class AddressTest extends Base {
  public function testAddress() {
    $address = self::createAddress();

    $this->assertNotEmpty($address);
    $this->assertEquals($address->getStreet(), 'Av. JK');
    $this->assertEquals($address->getNumber(), '909');
    $this->assertEquals($address->getNeighborhood(), 'Bauxita');
    $this->assertEquals($address->getZipcode(), '35400000');
  }
}