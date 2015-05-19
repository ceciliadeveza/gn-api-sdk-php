<?php

use Gerencianet\Gerencianet;
use Gerencianet\Models\Address;
use Gerencianet\Models\Customer;
use Gerencianet\Models\Item;
use Gerencianet\Models\Metadata;
use Gerencianet\Models\Repass;
use Gerencianet\Models\Shipping;
use Gerencianet\Models\Subscription;
use Gerencianet\Webservices\ApiBase;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Message\Response;

class Base extends PHPUnit_Framework_TestCase {

  public function createApiGN() {
    $apiKey = 'Client_Id_Test';
    $apiSecret = 'Client_Secret_Test';
    return new Gerencianet($apiKey, $apiSecret);
  }

  public function createRepass() {
    $repass = new Repass();

    return $repass->payeeCode('jsadkbfwfzmndck')
                  ->percentage(700);
  }

  public function createItem() {
    $item = new Item();

    return $item->name('Item 1')
                ->value(1000)
                ->amount(2)
                ->addRepass(self::createRepass());
  }

  public function createShipping() {
    $shipping = new Shipping();

    return $shipping->payeeCode('jsadkbfwfzmndck')
                    ->name('Shipping')
                    ->value(1575);
  }

  public function createMetadata() {
    $metadata = new Metadata();

    return $metadata->customId('MyID')
                    ->notificationUrl('http://localhost/teste.php');
  }

  public function createSubscription() {
    $subscription = new Subscription();

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
    $address = new Address();

    return $address->street('Street 3')
                   ->number('10')
                   ->neighborhood('Bauxita')
                   ->zipcode('35400000')
                   ->city('Ouro Preto')
                   ->state('MG');
  }

  public function createCustomer() {
    $customer = new Customer();

    return $customer->name('Gorbadoc Oldbuck')
                    ->email('oldbuck@gerencianet.com.br')
                    ->document('04267484171')
                    ->birth('1977-01-15')
                    ->phoneNumber('5044916523')
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