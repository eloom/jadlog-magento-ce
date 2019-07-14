<?php

##eloom.licenca##

class Eloom_Jadlog_ValorarResponse {

	/**
	 * @var string $valorarReturn
	 * @access public
	 */
	public $valorarReturn = null;

	/**
	 * @param string $valorarReturn
	 * @access public
	 */
	public function __construct($valorarReturn) {
		$this->valorarReturn = $valorarReturn;
	}

}
