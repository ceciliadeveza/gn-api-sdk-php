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
 * Gerencianet's detail charge class
 *
 * Implements how to use Gerencianet's detail charge
 *
 * @package Gerencianet
 */
class ApiDetailChargeGerencianet extends ApiBaseGerencianet {

  /**
   * charge id to detail
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
    $this->setUrl('/charge/detail');
  }

  /**
   * Set charge id
   *
   * @param  integer $id
   * @return ApiDetailChargeGerencianet
   */
  public function chargeId($id) {
    $this->_chargeId = $id;
    return $this;
  }

  /**
   * Get charge id
   *
   * @return integer
   */
  public function getchargeId() {
    return $this->_chargeId;
  }

  /**
   * Map parameters into data object
   *
   * @see ApiBaseGerencianet::mapData()
   * @return ApiDetailChargeGerencianet
   */
  public function mapData() {
    $this->_data['charge_id'] = $this->_chargeId;

    return $this;
  }
}
