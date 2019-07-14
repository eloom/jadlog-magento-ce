<?php

##eloom.licenca##

class Eloom_Jadlog_Volume {

	public $sku;

	public $quantidade;

	public $valor;

	public $altura;

	public $comprimento;

	public $largura;

	public $peso;

	public $agrupar;

	/**
	 * Eloom_Jadlog_Volume constructor.
	 * @param $sku
	 * @param $quantidade
	 * @param $valor
	 * @param $altura
	 * @param $comprimento
	 * @param $largura
	 * @param $peso
	 * @param $agrupar
	 */
	public function __construct($sku, $quantidade, $valor, $altura, $comprimento, $largura, $peso, $agrupar) {
		$this->sku = $sku;
		$this->quantidade = $quantidade;
		$this->valor = $valor;
		$this->altura = $altura;
		$this->comprimento = $comprimento;
		$this->largura = $largura;
		$this->peso = $peso;
		$this->agrupar = $agrupar;
	}
}