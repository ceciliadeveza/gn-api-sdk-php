<?php

namespace Gerencianet\Helpers;

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
 * Gerencianet's item class
 *
 * Class that abstract and return item attributes as required for api
 * @package Gerencianet
 */
class ItemGerencianet {

  /**
   * Name of item
   *
   * @var string
   */
  private $_name;

  /**
   * Value of item
   *
   * @var integer
   */
  private $_value;

  /**
   * Amount of item
   *
   * @var integer
   */
  private $_amount = 1;

  /**
   * Marketplace configurations of item
   *
   * @var MarketplaceGerencianet
   */
  private $_marketplace;

  /**
   * Set name of item
   *
   * @param  string $name
   * @return ItemGerencianet
   */
  public function name($name) {
    $this->_name = $name;
    return $this;
  }

  /**
   * Get name of item
   *
   * @return string
   */
  public function getName() {
    return $this->_name;
  }

  /**
   * Set value of item
   *
   * @param  integer $value
   * @return ItemGerencianet
   */
  public function value($value) {
    $this->_value = (int)$value;
    return $this;
  }

  /**
   * Get value of item
   *
   * @return integer
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * Set amount of item
   *
   * @param  integer $amount
   * @return ItemGerencianet
   */
  public function amount($amount) {
    $this->_amount = (int)$amount;
    return $this;
  }

  /**
   * Get amount of item
   *
   * @return integer
   */
  public function getAmount() {
    return $this->_amount;
  }

  /**
   * Set marketplace configurations of item
   *
   * @param  MarketplaceGerencianet $marketplace
   * @return ItemGerencianet
   */
  public function marketplace(MarketplaceGerencianet $marketplace) {
    $this->_marketplace = $marketplace;
    return $this;
  }

  /**
   * Get marketplace configurations of item
   *
   * @return MarketplaceGerencianet
   */
  public function getMarketplace() {
    return $this->_marketplace;
  }

  /**
   * Get the item as array
   *
   * @return array
   */
  public function toArray() {
    $item = [
      'name' => $this->_name,
      'value' => $this->_value,
      'amount' => $this->_amount
    ];

    if($this->_marketplace) {
      $item['marketplace'] = $this->_marketplace->toArray();
    }

    return $item;
  }
}