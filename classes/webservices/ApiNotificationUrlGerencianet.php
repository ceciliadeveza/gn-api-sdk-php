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
 * Gerencianet's notification url class
 *
 * Implements how to use Gerencianet's notification url
 *
 * @package Gerencianet
 */
class ApiNotificationUrlGerencianet extends ApiBaseGerencianet {

  /**
   * Url that specify where transaction's notifications must be sent
   *
   * @var string
   */
  private $_notificationUrl;

  /**
   * Charge id that will be associated with the transaction
   *
   * @var integer
  */
  private $_chargeId;

  /**
   * Construct method
   *
   * @param string $clientId
   * @param string $clientSecret
   * @param boolean $isTest
   */
  public function __construct($clientId, $clientSecret, $isTest) {
    parent::__construct($clientId, $clientSecret, $isTest);
    $this->setUrl('/notification/update');
  }

  /**
   * Sets the value of notification url
   *
   * @param string $notificationUrl
   * @return ApiNotificationUrlGerencianet
   */
  public function notificationUrl($notificationUrl) {
    $this->_notificationUrl = $notificationUrl;
    return $this;
  }

  /**
   * Gets the value of notification url
   *
   * @return string
   */
  public function getNotificationUrl() {
    return $this->_notificationUrl;
  }

  /**
   * Set charge id of charge
   *
   * @param  integer $chargeId
   * @return ApiNotificationUrlGerencianet
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
   * Map parameters into data object
   *
   * @see ApiBaseGerencianet::mapData()
   * @return ApiNotificationUrlGerencianet
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    $this->_data['notification_url'] = $this->_notificationUrl;

    return $this;
  }
}