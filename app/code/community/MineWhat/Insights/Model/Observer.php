<?php

class MineWhat_Insights_Model_Observer
{
    public function logCartAdd() {

        $product = Mage::getModel('catalog/product')
                        ->load(Mage::app()->getRequest()->getParam('product', 0));

        if (!$product->getId()) {
            return;
        }

        Mage::getModel('core/session')->setProductToShoppingCart(
            new Varien_Object(array(
                'id' => $product->getId()
            ))
        );
    }
}
