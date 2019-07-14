<?php

##eloom.licenca##

class Eloom_Jadlog_ConsultarResponse {

	/**
	 * @var string $consultarReturn
	 * @access public
	 */
	public $consultarReturn = null;

	private $error = null;

	public $tracking = null;

	/**
	 * @param string $consultarReturn
	 * @access public
	 */
	public function __construct($consultarReturn) {
		$this->consultarReturn = $consultarReturn;
	}


	public function xmlToObject() {
		$xml = simplexml_load_string($this->consultarReturn);
		$this->tracking = $xml->Jadlog_Tracking_Consultar;

		if (isset($this->tracking->Retorno) && $this->tracking->Retorno == '-1') {
			$this->error = $this->tracking->Mensagem->__toString();
		}
		$this->consultarReturn = null;

		return $this;
	}

	public function hasError() {
		if (!is_null($this->error)) {
			return true;
		}

		return false;
	}

	public function getError() {
		return $this->error;
	}
}
