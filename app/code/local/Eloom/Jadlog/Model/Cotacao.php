<?php

##eloom.licenca##

class Eloom_Jadlog_Model_Cotacao extends Mage_Core_Model_Abstract {

	private $logger;

	/**
	 * Initialize resource model
	 */
	protected function _construct() {
		$this->logger = Eloom_Bootstrap_Logger::getLogger(__CLASS__);
		parent::_construct();
	}

	/**
	 *
	 * @return type
	 */
	public function consultar($data) {
		$config = Mage::helper('eloom_jadlog/config');

		$request = array(
			'uri' => '/cotacao/consultar',
			'data' => $data
		);

		$response = null;

		try {
			$api = new Eloom_GetModal_Api($config->getGmAccessKey(), $config->getGmAccessToken());
			$text = $api->post($request);

			if ($config->isWriteLog()) {
				$this->logger->info($data);
				$this->logger->info($text);
			}
			$response = Eloom_GetModal_Response::getInstance()->prepare($text);
		} catch(Exception $e) {
			$response = Eloom_GetModal_Response::getInstance()->prepare(array('errors' => array($e->getMessage())));
			$this->logger->fatal($e->getMessage());
		}

		return $response;
	}

}
