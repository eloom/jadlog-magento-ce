<?php

##eloom.licenca##

class Eloom_GetModal_Api {

	const version = "1.0.0";

	private $clientKey;
	private $clienteToken;
	private $accessData;

	function __construct() {
		$i = func_num_args();

		if ($i != 2) {
			throw new Exception("Invalid arguments. Use GMKEY and GMTOKEN.");
		}

		$this->clientKey = func_get_arg(0);
		$this->clientToken = func_get_arg(1);
	}

	/**
	 * Get Headers
	 */
	private function getHeaders() {
		return array('GMKEY' => $this->clientKey,
			'GMTOKEN' => $this->clientToken);
	}

	/* Generic resource call methods */

	/**
	 * Generic resource get
	 * @param request
	 * @param params (deprecated)
	 * @param authenticate = true (deprecated)
	 */
	public function get($request, $params = null, $authenticate = true) {
		if (is_string($request)) {
			$request = array(
				'uri' => $request,
				'params' => $params,
				'authenticate' => $authenticate
			);
		}
		$request['params'] = isset($request['params']) && is_array($request['params']) ? $request['params'] : array();

		if (!isset($request['headers'])) {
			$request['headers'] = $this->getHeaders();
		}

		$result = Eloom_GetModal_RestClient::get($request);
		return $result;
	}

	/**
	 * Generic resource post
	 * @param request
	 * @param data (deprecated)
	 * @param params (deprecated)
	 */
	public function post($request, $data = null, $params = null) {
		if (is_string($request)) {
			$request = array(
				"uri" => $request,
				"data" => $data,
				"params" => $params
			);
		}
		$request["params"] = isset($request["params"]) && is_array($request["params"]) ? $request["params"] : array();
		if (!isset($request['headers'])) {
			$request['headers'] = $this->getHeaders();
		}

		$result = Eloom_GetModal_RestClient::post($request);
		return $result;
	}

	/**
	 * Generic resource put
	 * @param request
	 * @param data (deprecated)
	 * @param params (deprecated)
	 */
	public function put($request, $data = null, $params = null) {
		if (is_string($request)) {
			$request = array(
				"uri" => $request,
				"data" => $data,
				"params" => $params
			);
		}

		$request["params"] = isset($request["params"]) && is_array($request["params"]) ? $request["params"] : array();

		if (!isset($request['headers'])) {
			$request['headers'] = $this->getHeaders();
		}

		$result = Eloom_GetModal_RestClient::put($request);
		return $result;
	}
}