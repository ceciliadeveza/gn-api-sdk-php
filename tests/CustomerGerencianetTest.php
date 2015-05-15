<?php

require_once __DIR__.'/Base.php';

class CustomerGerencianetTest extends Base {

  public function testCustomer() {
    $customer = self::createCustomer();

    $this->assertNotEmpty($customer);
    $this->assertEquals($customer->getName(), 'Gerencianet Pagamentos do Brasil');
    $this->assertEquals($customer->getEmail(), 'suporte@gerencianet.com.br');
    $this->assertEquals($customer->getDocument(), '26245144000100');
    $this->assertEquals($customer->getBirth(), '1995-05-02');
    $this->assertEquals($customer->getPhoneNumber(), '3136030800');
    $this->assertNotEmpty($customer->getAddress());

    $addressCustomer = $customer->getAddress();
    $this->assertEquals($addressCustomer->getStreet(), 'Av. JK');
    $this->assertEquals($addressCustomer->getNumber(), '909');
    $this->assertEquals($addressCustomer->getNeighborhood(), 'Bauxita');
    $this->assertEquals($addressCustomer->getZipcode(), '35400000');
  }
}