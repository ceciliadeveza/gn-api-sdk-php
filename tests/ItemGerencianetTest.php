<?php

require_once __DIR__.'/Base.php';

class ItemGerencianetTest extends Base {

  public function testItem() {
    $item = self::createItem();

    $this->assertNotEmpty($item);
    $this->assertEquals($item->getName(), 'Item 1');
    $this->assertEquals($item->getValue(), 1000);
    $this->assertEquals($item->getAmount(), 2);
    $this->assertNotEmpty($item->getMarketplace());
  }
}