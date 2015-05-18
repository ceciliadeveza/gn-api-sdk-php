<?php

require_once __DIR__.'/Base.php';

class MarketplaceTest extends Base {

  public function testMarketplace() {
    $mkp = self::createMarketplace();

    $this->assertNotEmpty($mkp);
    $this->assertNotEmpty($mkp->getRepasses());
    $this->assertEquals(count($mkp->getRepasses()), 1);
  }
}