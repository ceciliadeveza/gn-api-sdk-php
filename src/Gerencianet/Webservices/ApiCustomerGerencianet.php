<?php

namespace Gerencianet\Webservices;
use Gerencianet\Helpers\CustomerGerencianet;

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
 * Gerencianet's customer class
 *
 * Implements how to add customer to Gerencianet's charge
 *
 * @package Gerencianet
 */
class ApiCustomerGerencianet extends ApiBaseGerencianet {

  /**
   * Charge id that will be associated to the customer
   *
   * @var integer
   */
  private $_chargeId;

  /**
   * Customer's attributes
   *
   * @var CustomerGerencianet
   */
  private $_customer;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/customer');
  }

  /**
   * Set charge id of charge
   *
   * @param  integer $chargeId
   * @return ApiCheckoutGerencianet
   */
  public function chargeId($chargeId) {
    $this->_chargeId = (int)$chargeId;
    return $this;
  }

  /**
   * Get charge id of charge
   *
   * @return integer
   */
  public function getChargeId() {
    return $this->_chargeId;
  }

  /**
   * Set a customer of charge
   *
   * @param  CustomerGerencianet $customer
   * @return ApiCustomerGerencianet
   */
  public function customer(CustomerGerencianet $customer) {
    $this->_customer = $customer;
    return $this;
  }

  /**
   * Get a customer of charge
   *
   * @return CustomerGerencianet
   */
  public function getCustomer() {
    return $this->_customer;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBaseGerencianet::mapData()
   * @return ApiCustomerGerencianet
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    if($this->_customer) {
      $this->_data['name'] = $this->_customer->getName();
      $this->_data['email'] = $this->_customer->getEmail();
      $this->_data['document'] = $this->_customer->getDocument();
      $this->_data['birth'] = $this->_customer->getBirth();
      $this->_data['phone_number'] = $this->_customer->getPhoneNumber();
    }

    return $this;
  }
}
