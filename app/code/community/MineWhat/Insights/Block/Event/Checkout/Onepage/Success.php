<?php

/**
 * @category    MineWhat
 * @package     MineWhat_Insights
 * @copyright   Copyright (c) MineWhat
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MineWhat_Insights_Block_Event_Checkout_Onepage_Success extends Mage_Core_Block_Template {

	protected function _construct() {
		parent::_construct();
		$this->setTemplate('minewhat/insights/event/checkout/onepage/success.phtml');
	}

	public function getOrderInfo() {
		$lastOrderId = Mage::getSingleton('checkout/session')->getLastOrderId();

		$order = Mage::getSingleton('sales/order');
		$order->load($lastOrderId);

		if ($order && $order->getId()) {

			    $orderInfo['items'] = array();

			    $orderedItems = $order->getAllItems();

			    foreach($orderedItems as $item) {

					$orderInfo['items'][] = new Varien_Object(array(
					    'id' => $item->getProductId(),
					    'qty' => $item->getQtyOrdered()
					));

			    }

			    return new Varien_Object($orderInfo);
		}

		return null;
	}

	protected function _toHtml() {
		if (!$this->helper('minewhat_insights')->isModuleOutputEnabled()) {
		    return '';
		}
		return parent::_toHtml();
    	}

}
