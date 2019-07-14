<?php

##eloom.licenca##

class Eloom_GetModal_Calculo {

	private $codigo;

	private $nome;

	private $alerta;

	private $localidade;

	private $tarifa;

	private $prazo;

	private $valor;

	/**
	 * Eloom_GetModal_Calculo constructor.
	 * @param $codigo
	 * @param $nome
	 * @param $alerta
	 * @param $localidade
	 * @param $tarifa
	 * @param $prazo
	 * @param $valor
	 */
	public function __construct($codigo, $nome, $alerta, $localidade, $tarifa, $prazo, $valor) {
		$this->codigo = $codigo;
		$this->nome = $nome;
		$this->alerta = $alerta;
		$this->localidade = $localidade;
		$this->tarifa = $tarifa;
		$this->prazo = $prazo;
		$this->valor = floatval(str_replace(',', '.', (string)$valor));
	}


	/**
	 * @return mixed
	 */
	public function getCodigo() {
		return $this->codigo;
	}

	/**
	 * @return mixed
	 */
	public function getNome() {
		return $this->nome;
	}

	/**
	 * @return mixed
	 */
	public function getAlerta() {
		return $this->alerta;
	}

	/**
	 * @return mixed
	 */
	public function getLocalidade() {
		return $this->localidade;
	}

	/**
	 * @return mixed
	 */
	public function getTarifa() {
		return $this->tarifa;
	}

	/**
	 * @return mixed
	 */
	public function getPrazo() {
		return $this->prazo;
	}

	/**
	 * @return mixed
	 */
	public function getValor() {
		return $this->valor;
	}

	public function canShow() {
		if($this->getPrazo() != null && $this->getValor() > 0) {
			return true;
		}

		return false;
	}
}