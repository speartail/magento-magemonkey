<?php
/**
 * Author : Ebizmarts <info@ebizmarts.com>
 * Date   : 6/25/13
 * Time   : 3:22 PM
 * File   : AutoresponderController.php
 * Module : Ebizmarts_Magemonkey
 */
class Ebizmarts_Autoresponder_AutoresponderController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if(!Mage::helper('customer')->isLoggedIn()) {
            $this->_redirect('/');
        }
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $navigationBlock = $this->getLayout()->getBlock('customer_account_navigation');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Newsletter Subscription'));
        $this->renderLayout();


    }
    public function unsubscribeAction(){
        $params = $this->getRequest()->getParams();
        if(isset($params['email'])&&isset($params['list'])&&$params['store']) {
            $collection = Mage::getModel('ebizmarts_autoresponder/unsubscribe')->getCollection();
            $collection->addFieldToFilter('main_table.email',array('eq'=>$params['email']))
                        ->addFieldToFilter('main_table.list',array('eq'=>$params['list']))
                        ->addFieldToFilter('main_table.store_id',array('eq'=>$params['store']));
            if($collection->getSize() == 0) {
                $unsubscribe = Mage::getModel('ebizmarts_autoresponder/unsubscribe');
                $unsubscribe->setEmail($params['email'])
                            ->setList($params['list'])
                            ->setStoreId($params['store']);
                $unsubscribe->save();
            }
        }
        $this->loadLayout();
        $this->renderLayout();
    }
    public function savelistAction()
    {
        if(!Mage::helper('customer')->isLoggedIn()) {
            $this->_redirect('/');
        }
        $params = $this->getRequest()->getParams();
        $lists = Mage::helper('ebizmarts_autoresponder')->getLists();
        $email = Mage::helper('customer')->getCustomer()->getEmail();
        $storeId = Mage::app()->getStore()->getStoreId();

        foreach($lists as $key => $list) {
            $collection = Mage::getModel('ebizmarts_autoresponder/unsubscribe')->getCollection();
            $collection->addFieldToFilter('main_table.email',array('eq'=>$email))
                        ->addFieldToFilter('main_table.list',array('eq'=>$key))
                        ->addFieldToFilter('main_table.store_id',array('eq'=>$storeId));
            if(array_key_exists($key,$params) && $collection->getSize() > 0) { //try to remove
                $collection->getFirstItem()->delete();
            }
            else if(!array_key_exists($key,$params)&&$collection->getSize() == 0){
                $unsubscribe = Mage::getModel('ebizmarts_autoresponder/unsubscribe');
                $unsubscribe->setEmail($email)
                            ->setList($key)
                            ->setStoreId($storeId);
                Mage::log($unsubscribe);
                $unsubscribe->save();
            }
        }
        Mage::getSingleton('core/session')
            ->addSuccess($this->__('Lists updated'));

        $this->_redirect('ebizautoresponder/autoresponder');
    }
    protected function _getCustomerId()
    {
        if(Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerData = Mage::getSingleton('customer/session')->getCustomer();
            return $customerData->getId();
        }
    }
}