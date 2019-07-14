<?php

##eloom.licenca##

class Eloom_Jadlog_Consultar {

	/**
	 * @var string $CodCliente
	 * @access public
	 */
	public $CodCliente = null;

	/**
	 * @var string $Password
	 * @access public
	 */
	public $Password = null;

	/**
	 * @var string $NDs
	 * @access public
	 */
	public $NDs = null;

	/**
	 * @param string $CodCliente
	 * @param string $Password
	 * @param string $NDs
	 * @access public
	 */
	public function __construct($CodCliente, $Password, $NDs) {
		$this->CodCliente = $CodCliente;
		$this->Password = $Password;
		$this->NDs = $NDs;
	}

}
