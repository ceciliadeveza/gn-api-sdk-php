<?php

namespace Gerencianet\Webservices;

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
 * Gerencianet's payment methods class
 *
 * Implements how to use Gerencianet's payment methods
 *
 * @package Gerencianet
 */
class ApiPaymentMethodsGerencianet extends ApiBaseGerencianet {

  /**
   * Payment method. Can be 'visa', 'mastercard', 'aura', 'jcb', 'elo', 'amex'
   * 'diners', 'discover'
   *
   * @var string
   */
  private $_brand = 'visa';

  /**
   * Set if search is about 'boleto'
   *
   * @var boolean
   */
  private $_isBol = false;

   /**
   * Charge value.
   *
   * @var integer
  */
  private $_value;

  /**
   * Construct Method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/payment/methods');
  }

  /**
   * Set a brand of search
   *
   * @param  string $brand
   * @return ApiPaymentMethodsGerencianet
   */
  public function brand($brand) {
    $this->_brand = $brand;
    return $this;
  }

  /**
   * Get a brand of search
   *
   * @return string
   */
  public function getBrand() {
    return $this->_brand;
  }

  /**
   * Set the value of search
   *
   * @param  integer $value
   * @return ApiPaymentMethodsGerencianet
   */
  public function value($value) {
    $this->_value = (int)$value;
    return $this;
  }

  /**
   * Get the value of search
   *
   * @return integer
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * Set if search is bol
   *
   * @param  boolean $installments
   * @return ApiPaymentMethodsGerencianet
   */
  public function isBol($bol) {
    $this->_isBol = (int)$bol;
    return $this;
  }

  /**
   * Return true if searching for bol
   *
   * @return boolean
   */
  public function getIsBol() {
    return $this->_isBol;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBaseGerencianet::mapData()
   * @return ApiPaymentMethodsGerencianet
   */
  public function mapData() {
    if($this->_isBol) {
      $this->_data['method'] = 'bol';
    } else {
      $this->_data['method'] = $this->_brand;
    }

    $this->_data['total'] = $this->_value;

    return $this;
  }
}
