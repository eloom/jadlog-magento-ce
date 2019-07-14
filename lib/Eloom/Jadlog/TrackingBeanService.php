<?php

##eloom.licenca##

class Eloom_Jadlog_TrackingBeanService extends \SoapClient {

	/**
	 * @var array $classmap The defined classes
	 * @access private
	 */
	private static $classmap = array(
		'consultar' => 'Eloom_Jadlog_Consultar',
		'consultarResponse' => 'Eloom_Jadlog_ConsultarResponse',
		'consultarPedido' => 'Eloom_Jadlog_ConsultarPedido',
		'consultarPedidoResponse' => 'Eloom_Jadlog_ConsultarPedidoResponse');

	/**
	 * @param array $options A array of config values
	 * @param string $wsdl The wsdl file to use
	 * @access public
	 */
	public function __construct(array $options = array(), $wsdl = 'http://www.jadlog.com.br:8080/JadlogEdiWs/services/TrackingBean?wsdl') {
		foreach(self::$classmap as $key => $value) {
			if (!isset($options['classmap'][$key])) {
				$options['classmap'][$key] = $value;
			}
		}

		parent::__construct($wsdl, $options);
	}

	/**
	 * @param consultar $parameters
	 * @access public
	 * @return consultarResponse
	 */
	public function consultar(Eloom_Jadlog_Consultar $parameters) {
		return $this->__soapCall('consultar', array($parameters));
	}

	/**
	 * @param consultarPedido $parameters
	 * @access public
	 * @return consultarPedidoResponse
	 */
	public function consultarPedido(Eloom_Jadlog_ConsultarPedido $parameters) {
		return $this->__soapCall('consultarPedido', array($parameters));
	}

}