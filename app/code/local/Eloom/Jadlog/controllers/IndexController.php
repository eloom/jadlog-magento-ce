<?php

##eloom.licenca##

class Eloom_Jadlog_IndexController extends Mage_Checkout_Controller_Action {

  /**
   * Initialize
   */
  protected function _construct() {
    $this->logger = Eloom_Bootstrap_Logger::getLogger(__CLASS__);
  }

  public function indexAction() {

  }
}
