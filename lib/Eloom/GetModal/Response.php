<?php

##eloom.licenca##

class Eloom_GetModal_Response {

	private $errors = array();

	private $warnings = array();

	private $services = array();

	public static function getInstance() {
		return new Eloom_GetModal_Response();
	}

	public function prepare($text) {
		if (isset($text['errors'])) {
			$this->errors = $text['errors'];
		}
		if (isset($text['response'])) {
			$calculos = $text['response']['resposta'][0]['calculos'];

			if ($calculos && is_array($calculos)) {
				foreach($calculos as $calc) {
					$calculo = new Eloom_GetModal_Calculo($calc['servico_codigo_api'], $calc['servico_nome'], $calc['servico_alerta'], $calc['localidade'], $calc['tarifa'], $calc['prazo_estimado'], $calc['valor_frete']);
					if($calculo->canShow()) {
						$this->services[] = $calculo;
					} else {
						$this->warnings[] = $calculo->getAlerta();
					}
				}
			}
		}

		return $this;
	}

	public function hasErrors() {
		if (count($this->errors)) {
			return true;
		}

		return false;
	}

	public function getError() {
		return $this->errors[0];
	}

	public function hasWarnings() {
		if (count($this->warnings)) {
			return true;
		}

		return false;
	}

	public function getWarning() {
		return $this->warnings[0];
	}

	public function hasServices() {
		if (count($this->services)) {
			return true;
		}

		return false;
	}

	public function listServices() {
		return $this->services;
	}

}