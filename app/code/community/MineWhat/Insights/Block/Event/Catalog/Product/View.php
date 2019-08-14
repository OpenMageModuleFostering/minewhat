<?php

/**
 * @category    MineWhat
 * @package     MineWhat_Insights
 * @copyright   Copyright (c) MineWhat
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MineWhat_Insights_Block_Event_Catalog_Product_View extends Mage_Core_Block_Template {

	protected function _construct() {
		parent::_construct();
		$this->setTemplate('minewhat/insights/event/catalog/product/view.phtml');
	}

	public function getCurrentProduct() {
		return Mage::registry('current_product');
	}

	protected function _toHtml() {
		if (!$this->helper('minewhat_insights')->isModuleOutputEnabled()) {
		    return '';
		}
		return parent::_toHtml();
    	}

}
