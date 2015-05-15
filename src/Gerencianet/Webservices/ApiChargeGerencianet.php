<?php

namespace Gerencianet\Webservices;
use Gerencianet\Helpers\CustomerGerencianet;
use Gerencianet\Helpers\MetadataGerencianet;
use Gerencianet\Helpers\SubscriptionGerencianet;

/**
 * Library to use Gerencianet's Api
 *
 * @author Danniel Hugo <suportetecnico@gerencianet.com.br>
 * @author Talita Campos <suportetecnico@gerencianet.com.br>
 * @author Francisco Thiene <suportetecnico@gerencianet.com.br>
 * @author Cecilia Deveza <suportetecnico@gerencianet.com.br>
 * @author Thomaz Feitoza <suportetecnico@gerencianet.com.br>
 *
 * @version 0.1.0
 * @license http://opensource.org/licenses/MIT
 */

/**
 * Gerencianet's charge class
 *
 * Implements how to use Gerencianet's charge
 *
 * @package Gerencianet
 */
class ApiChargeGerencianet extends ApiBaseGerencianet {

  /**
   * Set of items for this charge
   *
   * @var array
   */
  private $_cart;

  /**
   * Set of shippings for this charge
   *
   * @var array
   */
  private $_shippings;

  /**
   * Metadata's attributes
   *
   * @var MetadataGerencianet
   */
  private $_metadata;

  /**
   * Customer's attributes
   *
   * @var CustomerGerencianet
   */
  private $_customer;

   /**
   * Subscription's attributes
   *
   * @var SubscriptionGerencianet
   */
  private $_subscription;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/charge');
    $this->_cart = [];
    $this->_shippings = [];
    $this->_metadata = new MetadataGerencianet();
  }

  /**
   * Add a new item to the set of items
   *
   * @param  ItemGerencianet $item
   * @return ApiChargeGerencianet
   */
  public function addItem($item) {
    $this->_cart[] = $item->toArray();
    return $this;
  }

  /**
   * Add a array of new items to the set of items
   *
   * @param  Array $items
   * @return ApiChargeGerencianet
   */
  public function addItems($items) {
    foreach($items as $item) {
      $this->_cart[] = $item->toArray();
    }
    return $this;
  }

  /**
   * Get items of charge
   *
   * @return array
   */
  public function getItems() {
    return $this->_cart;
  }

  /**
   * Add a new shipping to the set of shippings
   *
   * @param  ShippingGerencianet $shipping
   * @return ApiChargeGerencianet
   */
  public function addShipping($shipping) {
    $this->_shippings[] = $shipping->toArray();
    return $this;
  }

  /**
   * Add a array of new shippings to the set of shippings
   *
   * @param  Array $shippings
   * @return ApiChargeGerencianet
   */
  public function addShippings($shippings) {
    foreach($shippings as $shipping) {
      $this->_shippings[] = $shipping->toArray();
    }
    return $this;
  }

  /**
   * Get shippings of charge
   *
   * @return array
   */
  public function getshippings() {
    return $this->_shippings;
  }

  /**
   * Set a metadata of charge
   *
   * @param  MetadataGerencianet $metadata
   * @return ApiChargeGerencianet
   */
  public function metadata(MetadataGerencianet $metadata) {
    $this->_metadata = $metadata;
    return $this;
  }

  /**
   * Get metadata of charge
   *
   * @return MetadataGerencianet
   */
  public function getMetadata() {
    return $this->_metadata;
  }

  /**
   * Set a customer of charge
   *
   * @param  CustomerGerencianet $customer
   * @return ApiChargeGerencianet
   */
  public function customer(CustomerGerencianet $customer) {
    $this->_customer = $customer;
    return $this;
  }

  /**
   * Get the customer of charge
   *
   * @return CustomerGerencianet
   */
  public function getCustomer() {
    return $this->_customer;
  }

  /**
   * Set subscription of charge
   *
   * @param  SubscriptionGerencianet $subscription
   * @return ApiChargeGerencianet
   */
  public function subscription(SubscriptionGerencianet $subscription) {
    $this->_subscription = $subscription;
    return $this;
  }

  /**
   * Get subscription of charge
   *
   * @return SubscriptionGerencianet
   */
  public function getSubscription() {
    return $this->_subscription;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBaseGerencianet::mapData()
   * @return ApiChargeGerencianet
   */
  public function mapData() {
    $this->_data['items'] = $this->_cart;

    if($this->_shippings) {
      $this->_data['shippings'] = $this->_shippings;
    }

    $metadata = $this->_metadata->toArray();

    if(!empty($metadata)) {
      $this->_data['metadata'] = $metadata;
    }

    if($this->_customer) {
      $this->_data['customer'] = $this->_customer->toArray();
    }

    if($this->_subscription) {
      $this->_data['subscription'] = $this->_subscription->toArray();
    }

    return $this;
  }
}
