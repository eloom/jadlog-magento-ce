<?php

##eloom.licenca##

class Eloom_Jadlog_Model_System_Config_Source_ServicosFree {

	public function toOptionArray() {
		$model = Mage::getSingleton('eloom_jadlog/carrier');
		$arr = array();
		$arr[] = array('value' => 'N', 'label' => 'Nenhum');

		foreach($model->getCode('service') as $k => $v) {
			$arr[] = array('value' => $k, 'label' => $v);
		}
		return $arr;
	}

}
