<?php

##eloom.licenca##

class Eloom_Jadlog_Model_System_Config_Source_FormatoEmbalagem {

	/**
	 * @return array
	 */
	public function toOptionArray() {
		return array(
			array('value' => '1', 'label' => Mage::helper('eloom_jadlog')->__('Caixa/Pacote')),
			array('value' => '2', 'label' => Mage::helper('eloom_jadlog')->__('Rolo/Prisma')),
			array('value' => '3', 'label' => Mage::helper('eloom_jadlog')->__('Envelope')),
		);
	}

}
