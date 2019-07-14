<?php

##eloom.licenca##

class Eloom_Jadlog_Model_Carrier extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface {

	const CODE = 'eloom_jadlog';
	const COUNTRY = 'BR';

	/**
	 * Código do Método de Frete
	 * @var type
	 */
	protected $_code = self::CODE;
	protected $_result = null;
	protected $_fromZip = null;
	protected $_toZip = null;
	protected $_config = null;
	protected $_freeMethod = null;
	protected $_hasFreeMethod = false;
	// dimensoes
	protected $_nVlComprimento = 0;
	protected $_nVlAltura = 0;
	protected $_nVlLargura = 0;

	/**
	 * Volumes
	 */
	protected $_volumes = array();

	/**
	 *
	 * @var type
	 */
	private $logger;

	/**
	 * Initialize resource model
	 */
	public function __construct() {
		parent::__construct();
		$this->logger = Eloom_Bootstrap_Logger::getLogger(__CLASS__);
		$this->_config = Mage::helper('eloom_jadlog/config');
	}

	public function getAllowedMethods() {
		$allowed = explode(',', $this->getConfigData('servico_codigo'));
		$arr = array();
		foreach($allowed as $k) {
			$arr[$k] = $this->getCode('service', $k);
		}
		return $arr;
	}

	/**
	 * Get configuration data of carrier
	 *
	 * @param string $type
	 * @param string $code
	 * @return array|bool
	 */
	public function getCode($type, $code = '') {
		static $codes;
		$codes = array(
			'service' => array(
				'jadlog_package' => $this->_config->__('Tabela Rodoviária'),
				'jadlog_com' => $this->_config->__('Tabela Expressa')
			),
			'front' => array(
				'jadlog_package' => $this->_config->__('Rodoviário'),
				'jadlog_com' => $this->_config->__('Expresso')
			)
		);

		if (!isset($codes[$type])) {
			return false;
		} elseif ('' === $code) {
			return $codes[$type];
		}

		if (!isset($codes[$type][$code])) {
			return false;
		} else {
			return $codes[$type][$code];
		}
	}

	public function collectRates(Mage_Shipping_Model_Rate_Request $request) {
		if ($this->_check($request) === false) {
			return $this->_result;
		}
		if (!preg_match('/^([0-9]{8})$/', $this->_toZip)) {
			return $this->_result;
		}

		if ($this->_getRates()->getError()) {
			return $this->_result;
		}

		return $this->_result;
	}

	/**
	 * Make initial checks and iniciate module variables
	 *
	 * @param Mage_Shipping_Model_Rate_Request $request
	 *
	 * @return bool
	 */
	protected function _check(Mage_Shipping_Model_Rate_Request $request) {
		if (!$this->getConfigFlag('active')) {
			return false;
		}

		$this->_result = Mage::getModel('shipping/rate_result');
		$origCountry = Mage::getStoreConfig('shipping/origin/country_id', $this->getStore());
		$destCountry = $request->getDestCountryId();
		if ($origCountry != self::COUNTRY || $destCountry != self::COUNTRY) {
			$rate = Mage::getModel('shipping/rate_result_error');
			$rate->setCarrier($this->_code);
			$rate->setCarrierTitle($this->getConfigData('title'));
			$rate->setErrorMessage(Eloom_Jadlog_ErrorMessages::getMessage('002'));
			$this->_result->append($rate);

			return false;
		}
		$this->_fromZip = Mage::getStoreConfig('shipping/origin/postcode', $this->getStore());
		$this->_toZip = $request->getDestPostcode();

		// Fix ZIP code
		$this->_fromZip = str_replace(array('-', '.'), '', trim($this->_fromZip));
		$this->_toZip = str_replace(array('-', '.'), '', trim($this->_toZip));
		$this->_toZip = str_replace('-', '', $this->_toZip);

		if (!preg_match('/^([0-9]{8})$/', $this->_fromZip)) {
			$rate = Mage::getModel('shipping/rate_result_error');
			$rate->setCarrier($this->_code);
			$rate->setCarrierTitle($this->getConfigData('title'));
			$rate->setErrorMessage(Eloom_Jadlog_ErrorMessages::getMessage('003'));
			$this->_result->append($rate);

			return false;
		}

		$comprimento = null;
		$altura = null;
		$largura = null;
		$peso = null;
		$preco = null;
		$qty = null;

		$widthAttr = $this->_config->getWidthAttr();
		$heightAttr = $this->_config->getHeightAttr();
		$lengthAttr = $this->_config->getLengthAttr();
		$weightAttr = $this->_config->getWeightAttr();

		foreach($request->getAllItems() as $item) {
			$qty = null;

			if ($item->getProduct()->isVirtual()) {
				continue;
			}

			if ($item->getHasChildren()) {
				foreach($item->getChildren() as $child) {
					if (!$child->getProduct()->isVirtual()) {
						$productId = $child->getProductId();
						$product = Mage::getModel('catalog/product');
						$product->setStoreId($this->getStore());
						$product->load($productId);
						$preco = ($item->getPrice() - $item->getDiscountAmount());

						$parentIds = Mage::getModel('catalog/product_type_grouped')->getParentIdsByChild($productId);
						if (!$parentIds) {
							$parentIds = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($productId);

							if ($parentIds) {
								$parentProd = Mage::getModel('catalog/product')->load($parentIds[0]);
								$comprimento = $parentProd->getData($widthAttr);
								$altura = $parentProd->getData($heightAttr);
								$largura = $parentProd->getData($widthAttr);
							}
						}

						$this->_volumes[$item->getSku()] = new Eloom_Jadlog_Volume($item->getSku(),
							$item->getQty(),
							$preco,
							$altura,
							$comprimento,
							$largura,
							$product->getData($weightAttr),
							'false');
					}
				}
			} else {
				$productId = $item->getProductId();
				$product = Mage::getModel('catalog/product');
				$product->setStoreId($this->getStore());
				$product->load($productId);

				if (isset($this->_volumes[$item->getSku()])) {
					$this->_volumes[$item->getSku()]->peso = $product->getData($weightAttr);
				} else {
					$this->_volumes[$item->getSku()] = new Eloom_Jadlog_Volume($item->getSku(),
						$item->getQty(),
						($item->getPrice() - $item->getDiscountAmount()),
						$product->getData($heightAttr),
						$product->getData($widthAttr),
						$product->getData($widthAttr),
						$product->getData($weightAttr),
						'false');
				}
			}
		}

		/**
		 * Informa os Volumes padrão
		 */
		$this->_nVlAltura = $this->_config->getAlturaPadrao();
		$this->_nVlLargura = $this->_config->getLarguraPadrao();
		$this->_nVlComprimento = $this->_config->getComprimentoPadrao();

		$this->_hasFreeMethod = $request->getFreeShipping();
		$this->_freeMethod = $this->_config->getServicoGratuito();

		$this->_freeMethodWeight = number_format($request->getFreeMethodWeight(), 2, '.', '');
	}

	protected function _getRates() {
		$data = array('transportadora_codigos_servicos' => $this->_config->getCodigoServicos(),
			'cep_origem' => $this->_fromZip,
			'cep_destino' => $this->_toZip
		);

		$volumes = array();
		foreach($this->_volumes as $volume) {
			$volumes[] = array('sku' => $volume->sku,
				'quantidade' => $volume->quantidade,
				'valor' => $volume->valor,
				'altura' => ($volume->altura ? $volume->altura : $this->_nVlAltura),
				'comprimento' => ($volume->comprimento ? $volume->comprimento : $this->_nVlComprimento),
				'largura' => ($volume->largura ? $volume->largura : $this->_nVlLargura),
				'peso' => round($volume->peso, 2),
				'agrupar' => $volume->agrupar);
		}
		$data['volumes'] = $volumes;

		$cotacaoFrete = Mage::getModel('eloom_jadlog/cotacao');
		$response = $cotacaoFrete->consultar($data);

		if ($response->hasErrors() || $response->hasWarnings()) {
			$rate = Mage::getModel('shipping/rate_result_error');
			$rate->setCarrier($this->_code);
			$rate->setCarrierTitle($this->getConfigData('title'));

			if ($response->hasErrors()) {
				$rate->setErrorMessage($response->getError());
			} else {
				$rate->setErrorMessage($response->getWarning());
			}
			$this->_result->append($rate);

			return $this->_result;
		}

		foreach($response->listServices() as $servico) {
			$this->_appendService($servico);
		}

		return $this->_result;
	}

	private function _appendService(Eloom_GetModal_Calculo $calculo) {
		$rate = null;

		$method = $calculo->getCodigo();

		$rate = Mage::getModel('shipping/rate_result_method');
		$rate->setCarrier($this->_code);
		$rate->setCarrierTitle($this->getConfigData('title'));
		$rate->setMethod($method);

		$title = $this->getCode('front', $calculo->getCodigo());
		if ($this->_config->isShowPrazoEntrega()) {
			$s = $this->_config->getMensagemPrazoEntrega();
			$title = sprintf($s, $title, intval($calculo->getPrazo() + $this->_config->getPrazoExtra()));
		}
		if ($calculo->getAlerta() != '') {
			//$title = $title . ' [' . $calculo->getAlerta() . ']';
		}
		$title = substr($title, 0, 255);
		$rate->setMethodTitle($title);

		if ($this->_config->hasTaxaExtra()) {
			$v1 = floatval(str_replace(',', '.', (string)$this->_config->getValorTaxaExtra()));
			$v2 = $calculo->getValor();

			if ($this->_config->isTaxaExtraInValor()) {
				$rate->setPrice($v1 + $v2);
			} else if ($this->_config->isTaxaExtraInPercentual()) {
				$rate->setPrice($v2 + (($v1 * $v2) / 100));
			}
		} else {
			$rate->setPrice($calculo->getValor());
		}
		if ($this->_hasFreeMethod) {
			if ($method == $this->_freeMethod) {
				$rate->setPrice(0);
			}
			if ($method == $this->_freeMethodSameCEP) {
				$rate->setPrice(0);
			}
		}
		$rate->setCost(0);

		$this->_result->append($rate);
	}

	/**
	 * Check if current carrier offer support to tracking
	 *
	 * @return bool true
	 */
	public function isTrackingAvailable() {
		return true;
	}

	/**
	 * Get Tracking Info
	 *
	 * @param mixed $tracking
	 *
	 * @return mixed
	 */
	public function getTrackingInfo($tracking) {
		$result = $this->getTracking($tracking);
		if ($result instanceof Mage_Shipping_Model_Tracking_Result) {
			if ($trackings = $result->getAllTrackings()) {
				return $trackings[0];
			}
		} elseif (is_string($result) && !empty($result)) {
			return $result;
		}

		return false;
	}

	/**
	 * Get Tracking
	 *
	 * @param array $trackings
	 *
	 * @return Mage_Shipping_Model_Tracking_Result
	 */
	public function getTracking($trackings) {
		$this->_result = Mage::getModel('shipping/tracking_result');
		foreach((array)$trackings as $code) {
			$this->_getTracking($code);
		}

		return $this->_result;
	}

	/**
	 * Protected Get Tracking, opens the request to Jadlog
	 *
	 * @param string $nf
	 *
	 * @return bool
	 */
	protected function _getTracking($nf) {
		$localizacao = Mage::getModel('eloom_jadlog/localizacao');
		$response = $localizacao->consultar($nf);

		if ($response->hasError()) {
			$error = Mage::getModel('shipping/tracking_result_error');
			$error->setTracking($nf);
			$error->setCarrier($this->_code);
			$error->setCarrierTitle($this->getConfigData('title'));
			$error->setErrorMessage($response->getError());

			$this->_result->append($error);
		} else {
			$dataEntrega = str_replace('/', '-', $response->getDataHoraEntrega());

			$track = array(
				'deliverydate' => date('d-m-Y', strtotime($dataEntrega)),
				'deliverytime' => date('H:i', strtotime($dataEntrega)),
				'status' => htmlentities($response->getStatus()),
				'progressdetail' => $this->_eventsAsString($response->listEvents()),
			);
			$tracking = Mage::getModel('shipping/tracking_result_status');
			$tracking->setTracking($nf);
			$tracking->setCarrier($this->_code);
			$tracking->setCarrierTitle($this->getConfigData('title'));
			$tracking->addData($track);

			$this->_result->append($tracking);
		}
	}

	private function _eventsAsString($events) {
		$detail = array();
		foreach($events as $event) {
			$dataEntrega = str_replace('/', '-', $event->getDataHoraEvento());

			$detail[] = array(
				'deliverydate' => date('d-m-Y', strtotime($dataEntrega)),
				'deliverytime' => date('H:i', strtotime($dataEntrega)),
				'deliverylocation' => $event->getObservacao(),
				'activity' => $event->getDescricao(),
			);
		}

		return $detail;
	}

}