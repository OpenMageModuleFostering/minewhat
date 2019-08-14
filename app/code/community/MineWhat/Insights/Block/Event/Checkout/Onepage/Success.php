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

			if($item->getProductType() == "bundle") {

				$orderInfo['items'][$item->getItemId()] = array(					   
				    'id' => $item->getProductId(),
				    'parentId' => [],
				    'sku' => $item->getSku(),
				    'qty' => $item->getQtyOrdered(),
			     	    'price' => $item->getPrice(),
				    'bundle' => array()
				);

			} else if($item->getProductType() != "configurable") {

				if($orderInfo['items'][$item->getParentItemId()] != null) {
					$bundleItems = $orderInfo['items'][$item->getParentItemId()]['bundle'];
					$bundleItem = array(
						'id' => $item->getProductId(),
					    	'sku' => $item->getSku(),
					    	'qty' => $item->getQtyOrdered(),
						'price' => $item->getPrice()
					);
					$bundleItems[] = $bundleItem;
					$orderInfo['items'][$item->getParentItemId()]['bundle'] = $bundleItems;
				
				} else {

					$orderInfo['items'][] = array(					   
					    'id' => $item->getProductId(),
					    'parentId' => Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($item->getProductId()),
					    'sku' => $item->getSku(),
					    'qty' => $item->getQtyOrdered(),
					    'price' => $item->getPrice(),
					    'bundle' => array()
					);

				}
				
			}

		    }

		    return $orderInfo;
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
