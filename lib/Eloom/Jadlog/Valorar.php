<?php

##eloom.licenca##

class Eloom_Jadlog_Valorar {

	/**
	 * @var int $vModalidade
	 * @access public
	 */
	public $vModalidade = null;

	/**
	 * @var string $Password
	 * @access public
	 */
	public $Password = null;

	/**
	 * @var string $vSeguro
	 * @access public
	 */
	public $vSeguro = null;

	/**
	 * @var string $vVlDec
	 * @access public
	 */
	public $vVlDec = null;

	/**
	 * @var string $vVlColeta
	 * @access public
	 */
	public $vVlColeta = null;

	/**
	 * @var string $vCepOrig
	 * @access public
	 */
	public $vCepOrig = null;

	/**
	 * @var string $vCepDest
	 * @access public
	 */
	public $vCepDest = null;

	/**
	 * @var string $vPeso
	 * @access public
	 */
	public $vPeso = null;

	/**
	 * @var string $vFrap
	 * @access public
	 */
	public $vFrap = null;

	/**
	 * @var string $vEntrega
	 * @access public
	 */
	public $vEntrega = null;

	/**
	 * @var string $vCnpj
	 * @access public
	 */
	public $vCnpj = null;

	/**
	 * @param int $vModalidade
	 * @param string $Password
	 * @param string $vSeguro
	 * @param string $vVlDec
	 * @param string $vVlColeta
	 * @param string $vCepOrig
	 * @param string $vCepDest
	 * @param string $vPeso
	 * @param string $vFrap
	 * @param string $vEntrega
	 * @param string $vCnpj
	 * @access public
	 */
	public function __construct($vModalidade, $Password, $vSeguro, $vVlDec, $vVlColeta, $vCepOrig, $vCepDest, $vPeso, $vFrap, $vEntrega, $vCnpj) {
		$this->vModalidade = $vModalidade;
		$this->Password = $Password;
		$this->vSeguro = $vSeguro;
		$this->vVlDec = $vVlDec;
		$this->vVlColeta = $vVlColeta;
		$this->vCepOrig = $vCepOrig;
		$this->vCepDest = $vCepDest;
		$this->vPeso = $vPeso;
		$this->vFrap = $vFrap;
		$this->vEntrega = $vEntrega;
		$this->vCnpj = $vCnpj;
	}

}
