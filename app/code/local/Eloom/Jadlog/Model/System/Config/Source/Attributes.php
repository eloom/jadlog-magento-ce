<?php

##eloom.licenca##

class Eloom_Jadlog_Model_System_Config_Source_Attributes {

	public function toOptionArray() {
		$attributes = Mage::getResourceModel('catalog/product_attribute_collection')->getItems();
		$opts = array();
		$opts[] = array('value' => '', 'label' => Mage::helper('eloom_jadlog')->__('Selecione'));
		foreach($attributes as $attribute) {
			$front = $attribute->getFrontendLabel();

			if (!empty($front)) {
				$opts[] = array('value' => $attribute->getAttributecode(), 'label' => $attribute->getAttributecode());
			} else {
				$opts[] = array('value' => $attribute->getAttributecode(), 'label' => $attribute->getAttributecode());
			}
		}

		sort($opts);

		return $opts;
	}
}