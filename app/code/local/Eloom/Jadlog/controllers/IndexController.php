<?php

##eloom.licenca##

class Eloom_Jadlog_IndexController extends Mage_Checkout_Controller_Action {

  /**
   * Initialize
   */
  protected function _construct() {
    $this->logger = Eloom_Bootstrap_Logger::getLogger(__CLASS__);
  }

  public function indexAction() {
    //$this->loadLayout();

		$vModalidade = Eloom_Jadlog_Modalidade::ECONOMICO;
		$Password = 'hwpbKxE';
		$vSeguro = Eloom_Jadlog_Seguro::NORMAL;
		$vVlDec = 119.95;
		$vVlColeta = 10.0;
		$vCepOrig = '88330725';
		$vCepDest = '92480000';
		$vPeso = .300;
		$vFrap = 'N';
		$vEntrega = Eloom_Jadlog_Entrega::DOMICILIO;
		$vCnpj = '07308481000146';

		$valorar = new Eloom_Jadlog_Valorar($vModalidade, $Password, $vSeguro, $vVlDec, $vVlColeta, $vCepOrig, $vCepDest, $vPeso, $vFrap, $vEntrega, $vCnpj);

		$valorarService = new Eloom_Jadlog_ValorFreteBeanService();
		$result = $valorarService->valorar($valorar);

		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));

    //$this->renderLayout();
  }


  public function getmodalAction() {
		$config = Mage::helper('eloom_jadlog/config');

		$request = array(
			'uri' => '/cotacao/consultar',
			'data' => array('transportadora_codigos_servicos' => 'jadlog_package',
				'cep_origem' => '88330-725',
				'cep_destino' => '92010-130',
				'volumes' => array(
					array('sku' => 'A123-a',
						'quantidade' => 1,
						'valor' => 119.95,
						'altura' => 20,
						'comprimento' => 20,
						'largura' => 20,
						'peso' => 2,
						'agrupar' => 'false')
				)
			)
		);

		/* Api Call */
		$api = new Eloom_GetModal_Api($config->getGmAccessKey(), $config->getGmAccessToken());
		$response = $api->post($request);
	}
}
