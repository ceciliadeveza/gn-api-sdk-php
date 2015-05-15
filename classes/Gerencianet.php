<?php
/**
 * Library to use Gerencianet's Api
 *
 * @author Danniel Hugo <suportetecnico@gerencianet.com.br>
 * @author Talita Campos <suportetecnico@gerencianet.com.br>
 * @author Francisco Thiene <suportetecnico@gerencianet.com.br>
 * @author Cecilia Deveza <suportetecnico@gerencianet.com.br>
 *
 * @version 1.0.0
 * @license http://opensource.org/licenses/MIT
 */


/**
 * Gerencianet's Api class
 *
 * Class to use Gerencianet's webservices
 * @package Gerencianet
 */
class Gerencianet {

  /**
   * User's client id
   *
   * @var boolean
   */
  private $_clientId;

  /**
   * User's secret key
   *
   * @var string
   */
  private $_clientSecret;

  /**
   * Enable/disable test api
   *
   * @var boolean
   */
  private $_isTest;

  /**
   * Construct method
   *
   * @param string $clientId User's client id
   * @param string $clientSecret User's secret key
   * @param boolean $_isTest Enable/disable test api
   */
  public function __construct($clientId, $clientSecret, $isTest = false) {
    $this->_clientId = $clientId;
    $this->_clientSecret = $clientSecret;
    $this->_isTest = $isTest;
  }

  /**
   * Generate a charge
   *
   * @return ApiChargeGerencianet
   */
  public function createCharge() {
    $api = new ApiChargeGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Add a customer to charge
   *
   * @return ApiCustomerGerencianet
   */
  public function createCustomer() {
    $api = new ApiCustomerGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Generate a transaction using checkout
   *
   * @return ApiCheckoutGerencianet
   */
  public function createPayment() {
    $api = new ApiPaymentGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Get available installments for credit card brand
   *
   * @return ApiPaymentMethodsGerencianet
   */
  public function getInstallments() {
    $api = new ApiPaymentMethodsGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Get value total to boleto
   *
   * @return ApiPaymentMethodsGerencianet
   */
  public function getTotalBol() {
    $api = new ApiPaymentMethodsGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);

    $api->isBol(true);
    return $api;
  }

  /**
   * Get notifications of a token
   *
   * @return ApiNotificationGerencianet
   */
  public function getNotifications() {
    $api = new ApiNotificationGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Updated charge' notification url
   *
   * @return ApiNotificationUrlGerencianet
   */
  public function updateNotificationUrl() {
    $api = new ApiNotificationUrlGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Cancel the subscription
   *
   * @return ApiCancelSubscriptionGerencianet
   */
  public function cancelSubscription() {
    $api = new ApiCancelSubscriptionGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Detail the subscription
   *
   * @return ApiDetailSubscriptionGerencianet
   */
  public function detailSubscription() {
    $api = new ApiDetailSubscriptionGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Detail the charge
   *
   * @return ApiDetailChargeGerencianet
   */
  public function detailCharge() {
    $api = new ApiDetailChargeGerencianet($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }
}
