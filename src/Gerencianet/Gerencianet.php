<?php

namespace Gerencianet;
use Gerencianet\Models\GerencianetException;
use Gerencianet\Webservices\ApiBase;
use Gerencianet\Webservices\ApiCancelSubscription;
use Gerencianet\Webservices\ApiCharge;
use Gerencianet\Webservices\ApiCustomer;
use Gerencianet\Webservices\ApiDetailCharge;
use Gerencianet\Webservices\ApiDetailSubscription;
use Gerencianet\Webservices\ApiNotification;
use Gerencianet\Webservices\ApiNotificationUrl;
use Gerencianet\Webservices\ApiPayment;
use Gerencianet\Webservices\ApiPaymentMethods;

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
   * @return ApiCharge
   */
  public function createCharge() {
    $api = new ApiCharge($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Add a customer to charge
   *
   * @return ApiCustomer
   */
  public function createCustomer() {
    $api = new ApiCustomer($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Generate a transaction using checkout
   *
   * @return ApiPayment
   */
  public function createPayment() {
    $api = new ApiPayment($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Get available installments for credit card brand
   *
   * @return ApiPaymentMethods
   */
  public function getInstallments() {
    $api = new ApiPaymentMethods($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Get value total to boleto
   *
   * @return ApiPaymentMethods
   */
  public function getTotalBol() {
    $api = new ApiPaymentMethods($this->_clientId, $this->_clientSecret, $this->_isTest);

    $api->isBol(true);
    return $api;
  }

  /**
   * Get notifications of a token
   *
   * @return ApiNotification
   */
  public function getNotifications() {
    $api = new ApiNotification($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Updated charge' notification url
   *
   * @return ApiNotificationUrl
   */
  public function updateNotificationUrl() {
    $api = new ApiNotificationUrl($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Cancel the subscription
   *
   * @return ApiCancelSubscription
   */
  public function cancelSubscription() {
    $api = new ApiCancelSubscription($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Detail the subscription
   *
   * @return ApiDetailSubscription
   */
  public function detailSubscription() {
    $api = new ApiDetailSubscription($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

  /**
   * Detail the charge
   *
   * @return ApiDetailCharge
   */
  public function detailCharge() {
    $api = new ApiDetailCharge($this->_clientId, $this->_clientSecret, $this->_isTest);
    return $api;
  }

   /**
   * Error response handler.
   * This function prints the message of an exception or an string
   *
   * @param $e Exception or message to be printed
   */
  public static function error($e = '') {
    http_response_code(500);
    if($e instanceof GerencianetException) {
      echo $e->toString();
    } else if($e instanceof Exception) {
      echo $e->getMessage();
    } else {
      echo $e;
    }
  }

}
