<?php

##eloom.licenca##

class Eloom_Jadlog_Model_Localizacao extends Mage_Core_Model_Abstract {

	private $logger;

	/**
	 * Initialize resource model
	 */
	public function __construct() {
		$this->logger = Eloom_Bootstrap_Logger::getLogger(__CLASS__);
	}

	/**
	 *
	 * @param type $localizador
	 * @return null
	 */
	public function consultar($localizador) {
		$config = Mage::helper('eloom_jadlog/config');
		$user = trim($config->getJadlogCnpj()); // é o CNPJ do CLiente
		$pwd = trim($config->getJadlogPassword());

		if (empty($user) || empty($pwd)) {
			throw new RuntimeException('Convênio com a Jadlog não encontrado.');
		}
		$localizador = preg_replace("@0+@",'',$localizador);
		$parameters = new Eloom_Jadlog_ConsultarPedido($user, $pwd, $localizador);

		$client = new Eloom_Jadlog_TrackingBeanService(array('trace' => 0, 'connection_timeout' => 20));
		$response = $client->consultarPedido($parameters);

		if ($config->isWriteLog()) {
			$this->logger->info(sprintf("Response \n %s", $response->toString()));
		}

		return $response->xmlToObject();
	}

}
