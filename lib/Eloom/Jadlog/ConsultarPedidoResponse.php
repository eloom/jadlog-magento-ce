<?php

##eloom.licenca##

class Eloom_Jadlog_ConsultarPedidoResponse {

	/**
	 * @var string $consultarPedidoReturn
	 * @access public
	 */
	private $consultarPedidoReturn = null;

	private $error = null;

	private $events = null;

	private $status;

	private $dataHoraEntrega;

	private $statusList = array('TRANSFERENCIA' => 'Sua encomenda foi transferida para outra unidade Jadlog.',
		'ENTRADA' => 'Sua encomenda deu entrada em uma unidade Jadlog.',
		'EM ROTA' => 'Fique atento(a)! Estamos a caminho para entregar sua encomenda.',
		'EMISSAO' => 'Uma solicitação de emissão foi gerada na unidade Jadlog.',
		'ENTREGUE' => 'Sua encomenda foi entregue.',
		'ANALISE' => 'Ops...! Sua encomenda está em análise com nossa equipe. Em breve você receberá mais detalhes.'
	);

	/**
	 * @param string $consultarPedidoReturn
	 * @access public
	 */
	public function __construct($consultarPedidoReturn) {
		$this->consultarPedidoReturn = $consultarPedidoReturn;
	}

	public function xmlToObject() {
		$xml = simplexml_load_string($this->consultarPedidoReturn);
		$tracking = $xml->Jadlog_Tracking_Consultar;

		if(count($tracking->children()) == 0) {
			$this->error = 'Ainda não constam informações sobre seu localizador. Tente novamente mais tarde.';
		}

		if (isset($tracking->Retorno) && $tracking->Retorno == '-1') {
			$this->error = $tracking->Mensagem->__toString();
		}

		// events
		if (isset($tracking->ND) && count($tracking->ND->Evento)) {
			$this->status = $tracking->ND->Status->__toString();
			$this->dataHoraEntrega = $tracking->ND->DataHoraEntrega->__toString();

			foreach($tracking->ND->Evento as $e) {
				$this->events[] = new Eloom_Jadlog_Evento($e->Codigo->__toString(), $e->DataHoraEvento->__toString(), $e->Descricao->__toString(), $e->Observacao->__toString());
			}
		}

		return $this;
	}

	public function hasError() {
		if (!is_null($this->error)) {
			return true;
		}

		return false;
	}

	public function getError() {
		return $this->error;
	}

	public function hasEvents() {
		if (!is_null($this->events)) {
			return true;
		}

		return false;
	}

	public function listEvents() {
		return $this->events;
	}

	public function toString() {
		return $this->consultarPedidoReturn;
	}

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return Eloom_Jadlog_Helper_Config::getStatusDescription($this->status);
	}

	/**
	 * @return mixed
	 */
	public function getDataHoraEntrega() {
		return $this->dataHoraEntrega;
	}
}
