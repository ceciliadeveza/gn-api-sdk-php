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
 * Gerencianet's marketplace class
 *
 * Class that abstract and return marketplace attributes as required for api
 * @package Gerencianet
 */
class MarketplaceGerencianet {

  /**
   * Set of repasses
   *
   * @var array
   */
  private $_repasses;

   /**
   * Add a new repass to the set of repasses
   *
   * @param  RepassGerencianet $repass
   * @return MarketplaceGerencianet
   */
  public function addRepass(RepassGerencianet $repass) {
    $this->_repasses[] = $repass->toArray();
    return $this;
  }

  /**
   * Add a array of new repasses to the set of repasses
   *
   * @param  Array $repasses
   * @return MarketplaceGerencianet
   */
  public function addRepasses($repasses) {
    foreach($repasses as $repass) {
      $this->_repasses[] = $repass->toArray();
    }
    return $this;
  }

  /**
   * Get the set of repasses
   *
   * @return array
   */
  public function getRepasses() {
    return $this->_repasses;
  }

  /**
   * Get the marketplace attibutes as array
   *
   * @return array
   */
  public function toArray() {
    $arr = [
      'repasses' => $this->_repasses
    ];

    return $arr;
  }
}
