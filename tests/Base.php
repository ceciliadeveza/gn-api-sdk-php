<?php

use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Message\Response;

class Base extends PHPUnit_Framework_TestCase {

  public function createApiGN() {
    $apiKey = 'Client_Id_Test';
    $apiSecret = 'Client_Secret_Test';
    return new Gerencianet($apiKey, $apiSecret);
  }

  public function createRepass() {
    $repass = new RepassGerencianet();

    return $repass->payeeCode('jsadkbfwfzmndck')
                  ->percentage(700);
  }

  public function createMarketplace() {
    $mkp = new MarketplaceGerencianet();

    return $mkp->addRepass(self::createRepass());
  }

  public function createItem() {
    $item = new ItemGerencianet();

    return $item->name('Item 1')
                ->value(1000)
                ->amount(2)
                ->marketplace(self::createMarketplace());
  }

  public function createShipping() {
    $shipping = new ShippingGerencianet();

    return $shipping->payeeCode('jsadkbfwfzmndck')
                    ->name('Frete')
                    ->value(1575);
  }

  public function createMetadata() {
    $metadata = new MetadataGerencianet();

    return $metadata->customId('MYID')
                    ->notificationUrl('http://localhost/teste.php');
  }

  public function createSubscription() {
    $subscription = new SubscriptionGerencianet();

    return $subscription->repeats(2)
                        ->interval(1);
  }

  public function createCharge() {
    $apiGN = self::createApiGN();

    return $apiGN->createCharge()
                 ->addItem(self::createItem())
                 ->addItems([self::createItem(), self::createItem()])
                 ->addShipping(self::createShipping())
                 ->addShippings([self::createShipping(), self::createShipping()])
                 ->metadata(self::createMetadata())
                 ->subscription(self::createSubscription());
  }

  public function createAddress() {
    $address = new AddressGerencianet();

    return $address->street('Av. JK')
                   ->number('909')
                   ->neighborhood('Bauxita')
                   ->zipcode('35400000')
                   ->city('Ouro Preto')
                   ->state('MG');
  }

  public function createCustomer() {
    $customer = new CustomerGerencianet();

    return $customer->name("Gerencianet Pagamentos do Brasil")
                    ->email("suporte@gerencianet.com.br")
                    ->document("26245144000100")
                    ->birth('1995-05-02')
                    ->phoneNumber('3136030800')
                    ->address(self::createAddress());
  }

  public function getMockResponse($filename) {
    $mockResponse = new Response(200);
    $mockResponseBody = Stream::factory(file_get_contents(
        __DIR__.'/mock/'.$filename.'.json')
    );
    $mockResponse->setBody($mockResponseBody);

    return $mockResponse;
  }
}