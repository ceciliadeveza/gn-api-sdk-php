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
 * Gerencianet's shipping class
 *
 * Class that abstract and return shipping attributes as required for api
 * @package Gerencianet
 */
class ShippingGerencianet {

  /**
   * Payee code of account that will receive the shipping
   *
   * @var string
   */
  private $_payeeCode;

  /**
   * Name of shipping
   *
   * @var string
   */
  private $_name;

  /**
   * Value of shipping
   *
   * @var integer
   */
  private $_value;

  /**
   * Set payee code of shipping
   *
   * @param  string $payeeCode
   * @return ShippingGerencianet
   */
  public function payeeCode($payeeCode) {
    $this->_payeeCode = $payeeCode;
    return $this;
  }

  /**
   * Get payee code of shipping
   *
   * @return string
   */
  public function getPayeeCode() {
    return $this->_payeeCode;
  }


  /**
   * Set name of shipping
   *
   * @param  string $name
   * @return ShippingGerencianet
   */
  public function name($name) {
    $this->_name = $name;
    return $this;
  }

  /**
   * Get name of shipping
   *
   * @return string
   */
  public function getName() {
    return $this->_name;
  }

  /**
   * Set value of shipping
   *
   * @param  integer $value
   * @return ShippingGerencianet
   */
  public function value($value) {
    $this->_value = (int)$value;
    return $this;
  }

  /**
   * Get value of shipping
   *
   * @return integer
   */
  public function getValue() {
    return $this->_value;
  }

  /**
   * Get the shipping as array
   *
   * @return array
   */
  public function toArray() {
    $shipping = [
      'payee_code' => $this->_payeeCode,
      'name' => $this->_name,
      'value' => $this->_value
    ];

    return $shipping;
  }
}