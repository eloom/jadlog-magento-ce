<?php

##eloom.licenca##

class Eloom_Jadlog_Model_System_Config_Source_Servicos {

	public function toOptionArray() {
		$model = Mage::getSingleton('eloom_jadlog/carrier');
		$arr = array();
		foreach($model->getCode('service') as $k => $v) {
			$arr[] = array('value' => $k, 'label' => $v);
		}

		return $arr;
	}

}
