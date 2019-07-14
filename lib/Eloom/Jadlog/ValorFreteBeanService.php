<?php

##eloom.licenca##

class Eloom_Jadlog_ValorFreteBeanService extends \SoapClient {

	/**
	 * @var array $classmap The defined classes
	 * @access private
	 */
	private static $classmap = array(
		'valorar' => 'Eloom_Jadlog_Valorar',
		'valorarResponse' => 'Eloom_Jadlog_ValorarResponse');

	/**
	 * @param array $options A array of config values
	 * @param string $wsdl The wsdl file to use
	 * @access public
	 */
	public function __construct(array $options = array(), $wsdl = 'http://www.jadlog.com.br:8080/JadlogEdiWs/services/ValorFreteBean?wsdl') {
		foreach(self::$classmap as $key => $value) {
			if (!isset($options['classmap'][$key])) {
				$options['classmap'][$key] = $value;
			}
		}

		parent::__construct($wsdl, $options);
	}

	/**
	 * @param valorar $parameters
	 * @access public
	 * @return valorarResponse
	 */
	public function valorar(Eloom_Jadlog_Valorar $parameters) {
		return $this->__soapCall('valorar', array($parameters));
	}

}
