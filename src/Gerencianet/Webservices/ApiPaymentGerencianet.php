<?php

namespace Gerencianet\Webservices;
use Gerencianet\Helpers\AddressGerencianet;

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
 * Gerencianet's payment class
 *
 * Implements how to use Gerencianet's payment
 *
 * @package Gerencianet
 */
class ApiPaymentGerencianet extends ApiBaseGerencianet {

  /**
   * Billing address
   *
   * @var AddressGerencianet
   */
  private $_billingAddress;

  /**
   * Payment method. Can be 'credit_card' or 'bol'
   *
   * @var string
   */
  private $_method = 'credit_card';

  /**
   * Expiration date for 'bol'. The required format is 'YYYY-mm-dd'
   *
   * @var string
   */
  private $_expireAt;

  /**
   * Installments of transaction. It defines how many times a transaction will be
   * divided when using credit card
   *
   * @var string
   */
  private $_installments;

  /**
   * Charge id that will be associated with the transaction
   *
   * @var integer
  */
  private $_chargeId;

  /**
   * Payment token used for credit card
   *
   * @var string
   */
  protected $_paymentToken;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/payment/pay');
  }

  /**
   * Set a billing address of transaction
   *
   * @param  AddressGerencianet $address
   * @return ApiCheckoutGerencianet
   */
  public function billingAddress(AddressGerencianet $address) {
    $this->_billingAddress = $address;
    return $this;
  }

  /**
   * Get billing address of transaction
   *
   * @return AddressGerencianet
   */
  public function getBillingAddress() {
    return $this->billingAddress;
  }

  /**
   * Set the method used to pay this transaction. It can be 'credit_card' or 'bol'
   *
   * @param  string $method
   * @return ApiCheckoutGerencianet
   */
  public function method($method) {
    $this->_method = $method;
    return $this;
  }

  /**
   * Get the method used to pay this transaction
   *
   * @return string
   */
  public function getMethod() {
    return $this->_method;
  }

  /**
   * Set an expiration date of transaction. The required format is 'YYYY-mm-dd'
   * and must be used just for 'bol'
   *
   * @param  string $expireAt
   * @return ApiCheckoutGerencianet
   */
  public function expireAt($expireAt) {
    $expireAt = str_replace('/', '-', $expireAt);
    $this->_expireAt = date("Y-m-d", strtotime($expireAt));
    return $this;
  }

  /**
   * Get an expiration date of transaction
   *
   * @return string
   */
  public function getExpireAt() {
    return $this->_expireAt;
  }

  /**
   * Set the amount of installments of transaction
   *
   * @param  integer $installments
   * @return ApiCheckoutGerencianet
   */
  public function installments($installments) {
    $this->_installments = (int)$installments;
    return $this;
  }

  /**
   * Get the amount of installments of transaction
   *
   * @return integer
   */
  public function getInstallments() {
    return $this->_installments;
  }

  /**
   * Set charge id of transaction
   *
   * @param  integer $chargeId
   * @return ApiCheckoutGerencianet
   */
  public function chargeId($chargeId) {
    $this->_chargeId = (int)$chargeId;
    return $this;
  }

  /**
   * Get charge id of transaction
   *
   * @return integer
   */
  public function getChargeId() {
    return $this->_chargeId;
  }

  /**
   * Set payment token. Must be used just for 'credit_card'
   *
   * @param  string $paymentToken
   * @return ApiCheckoutGerencianet
   */
  public function paymentToken($paymentToken) {
    $this->_paymentToken = $paymentToken;
    return $this;
  }

  /**
   * Get payment token
   *
   * @param  string $paymentToken
   * @return ApiCheckoutGerencianet
   */
  public function getPaymentToken() {
    return $this->_paymentToken;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBaseGerencianet::mapData()
   * @return ApiCheckoutGerencianet
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    $this->_data['payment'] = [];

    if($this->_method == 'credit_card') {
      $this->_data['payment']['credit_card'] = [];

      if($this->_installments) {
        $this->_data['payment']['credit_card']['installments'] = $this->_installments;
      }

      if($this->_paymentToken) {
        $this->_data['payment']['credit_card']['payment_token'] = $this->_paymentToken;
      }

      if($this->_billingAddress) {
        $this->_data['payment']['credit_card']['billing_address'] = $this->_billingAddress->toArray();
      }

    } else {
      $this->_data['payment']['bol'] = [];

      if($this->_expireAt) {
        $this->_data['payment']['bol']['expire_at'] = $this->_expireAt;
      }
    }

    return $this;
  }
}
