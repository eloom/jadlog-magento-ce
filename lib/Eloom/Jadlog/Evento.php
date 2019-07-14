<?php

##eloom.licenca##

class Eloom_Jadlog_Evento {

	private $codigo;

	private $dataHoraEvento;

	private $descricao;

	private $observacao;

	/**
	 * Eloom_Jadlog_Evento constructor.
	 * @param $codigo
	 * @param $cataHoraEvento
	 * @param $Descricao
	 * @param $bbservacao
	 */
	public function __construct($codigo, $dataHoraEvento, $descricao, $observacao) {
		$this->codigo = trim($codigo);
		$this->dataHoraEvento = trim($dataHoraEvento);
		$this->descricao = trim($descricao);
		$this->observacao = trim($observacao);
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
	public function getDataHoraEvento() {
		return $this->dataHoraEvento;
	}

	/**
	 * @return mixed
	 */
	public function getDescricao() {
		return Eloom_Jadlog_Helper_Config::getStatusDescription($this->descricao);
	}

	/**
	 * @return mixed
	 */
	public function getObservacao() {
		return $this->observacao;
	}

}
