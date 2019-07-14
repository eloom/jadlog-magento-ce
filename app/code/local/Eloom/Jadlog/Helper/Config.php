<?php

##eloom.licenca##

class Eloom_Jadlog_Helper_Config extends Mage_Core_Helper_Abstract {

	const XML_JADLOG_ACTIVE = 'carriers/eloom_jadlog/active';
	const XML_JADLOG_TITLE = 'carriers/eloom_jadlog/title';

	/**
	 * Chave de Acesso ao Sistema GetModal
	 */
	const XML_JADLOG_GMKEY = 'carriers/eloom_jadlog/gm_key';

	/**
	 * Token de Acesso ao Sistema GetModal
	 */
	const XML_JADLOG_GMTOKEN = 'carriers/eloom_jadlog/gm_token';

	/**
	 * Usuário JadLog
	 */
	const XML_JADLOG_JLUSER = 'carriers/eloom_jadlog/jl_user';
	/**
	 * Senha JadLog
	 */
	const XML_JADLOG_JLPASSWORD = 'carriers/eloom_jadlog/jl_password';
	/**
	 * Código do Cliente JadLog
	 */
	const XML_JADLOG_JLCLIENT = 'carriers/eloom_jadlog/jl_client';

	/**
	 * CNPJ
	 */
	const XML_JADLOG_JLCNPJ = 'carriers/eloom_jadlog/jl_cnpj';

	/**
	 * Código dos Serviços para cotações
	 */
	const XML_JADLOG_CD_SERVICO = 'carriers/eloom_jadlog/servico_codigo';

	/**
	 * Código do Serviço para Frete Grátis
	 */
	const XML_JADLOG_SERVICO_GRATUITO = 'carriers/eloom_jadlog/servico_gratis';

	const XML_JADLOG_ALTURA_PADRAO = 'carriers/eloom_jadlog/dimensoes_altura';
	const XML_JADLOG_LARGURA_PADRAO = 'carriers/eloom_jadlog/dimensoes_largura';
	const XML_JADLOG_COMPRIMENTO_PADRAO = 'carriers/eloom_jadlog/dimensoes_comprimento';


	const XML_JADLOG_PRAZO_ENTREGA = 'carriers/eloom_jadlog/prazos_entrega';
	const XML_JADLOG_MENSAGEM_PRAZO_ENTREGA = 'carriers/eloom_jadlog/prazos_mensagem';

	const XML_JADLOG_TAXA_EXTRA = 'carriers/eloom_jadlog/taxas_adicinal';
	const XML_JADLOG_TAXA_EXTRA_VALOR = 'carriers/eloom_jadlog/taxas_opcao';
	const XML_JADLOG_PRAZO_EXTRA = 'carriers/eloom_jadlog/prazo_extra';
	const XML_JADLOG_WRITE_LOG = 'carriers/eloom_jadlog/writelog';

	/**
	 * Atributos
	 */
	const XML_JADLOG_ATTR_WIDTH = 'carriers/eloom_jadlog/width';
	const XML_JADLOG_ATTR_HEIGHT = 'carriers/eloom_jadlog/height';
	const XML_JADLOG_ATTR_LENGTH = 'carriers/eloom_jadlog/length';
	const XML_JADLOG_ATTR_WEIGHT = 'carriers/eloom_jadlog/weight';

	private static $statusList = array('TRANSFERENCIA' => 'Sua encomenda foi transferida para outra unidade Jadlog.',
		'ENTRADA' => 'Sua encomenda deu entrada em uma unidade Jadlog.',
		'EM ROTA' => 'Fique atento(a)! Estamos a caminho para entregar sua encomenda.',
		'EMISSAO' => 'Uma solicitação de emissão foi gerada na unidade Jadlog.',
		'ENTREGUE' => 'Sua encomenda foi entregue.',
		'ANALISE' => 'Ops...! Sua encomenda está em com nossa equipe.'
	);

	public function getGmAccessKey() {
		return Mage::getStoreConfig(self::XML_JADLOG_GMKEY);
	}

	public function getGmAccessToken() {
		return Mage::getStoreConfig(self::XML_JADLOG_GMTOKEN);
	}

	public function getJadlogUser() {
		return Mage::getStoreConfig(self::XML_JADLOG_JLUSER);
	}

	public function getJadlogPassword() {
		return Mage::getStoreConfig(self::XML_JADLOG_JLPASSWORD);
	}

	public function getJadlogCnpj() {
		return Mage::getStoreConfig(self::XML_JADLOG_JLCNPJ);
	}

	public function hasTaxaExtra() {
		return Mage::getStoreConfigFlag(self::XML_JADLOG_TAXA_EXTRA);
	}

	public function isTaxaExtraInPercentual() {
		return (Mage::getStoreConfig(self::XML_JADLOG_TAXA_EXTRA) == '1');
	}

	public function isWriteLog() {
		return Mage::getStoreConfigFlag(self::XML_JADLOG_WRITE_LOG);
	}

	public function isTaxaExtraInValor() {
		return (Mage::getStoreConfig(self::XML_JADLOG_TAXA_EXTRA) == '2');
	}

	public function getValorTaxaExtra() {
		return Mage::getStoreConfig(self::XML_JADLOG_TAXA_EXTRA_VALOR);
	}

	public function isActive($storeId) {
		return Mage::getStoreConfigFlag(self::XML_JADLOG_ACTIVE, $storeId);
	}

	public function getTitle($storeId) {
		return Mage::getStoreConfig(self::XML_JADLOG_TITLE, $storeId);
	}

	public function getServicoGratuito() {
		return Mage::getStoreConfig(self::XML_JADLOG_SERVICO_GRATUITO);
	}

	public function getCodigoServicos() {
		return Mage::getStoreConfig(self::XML_JADLOG_CD_SERVICO);
	}

	public function isShowPrazoEntrega() {
		return Mage::getStoreConfigFlag(self::XML_JADLOG_PRAZO_ENTREGA);
	}

	public function getMensagemPrazoEntrega() {
		return Mage::getStoreConfig(self::XML_JADLOG_MENSAGEM_PRAZO_ENTREGA);
	}

	public function getAlturaPadrao() {
		return Mage::getStoreConfig(self::XML_JADLOG_ALTURA_PADRAO);
	}

	public function getLarguraPadrao() {
		return Mage::getStoreConfig(self::XML_JADLOG_LARGURA_PADRAO);
	}

	public function getComprimentoPadrao() {
		return Mage::getStoreConfig(self::XML_JADLOG_COMPRIMENTO_PADRAO);
	}

	public function getPrazoExtra() {
		return Mage::getStoreConfig(self::XML_JADLOG_PRAZO_EXTRA);
	}

	public function getWidthAttr() {
		return Mage::getStoreConfig(self::XML_JADLOG_ATTR_WIDTH);
	}

	public function getHeightAttr() {
		return Mage::getStoreConfig(self::XML_JADLOG_ATTR_HEIGHT);
	}

	public function getLengthAttr() {
		return Mage::getStoreConfig(self::XML_JADLOG_ATTR_LENGTH);
	}

	public function getWeightAttr() {
		return Mage::getStoreConfig(self::XML_JADLOG_ATTR_WEIGHT);
	}

	public static function getStatusDescription($status) {
		if (array_key_exists($status, self::$statusList)) {
			return self::$statusList[$status];
		}

		return $status;
	}
}
