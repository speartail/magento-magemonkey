<?php
/**
 * Author : Ebizmarts <info@ebizmarts.com>
 * Date   : 5/7/13
 * Time   : 11:33 PM
 * File   : AbandonedmailsController.php
 * Module : Ebizmarts_Magemonkey
 */
class Ebizmarts_AbandonedCart_Adminhtml_AbandonedmailsController  extends Mage_Adminhtml_Controller_Action
{
    /**
     *
     */
    public function indexAction()
    {
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * @return Ebizmarts_AbandonedCart_Adminhtml_AbandonedorderController
     */
    protected function _initAction()
    {
        $this->loadLayout()
            // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('sales/ebizmarts_abandonedcart')
            ->_title($this->__('Sales'))->_title($this->__('Abandoned'))
            ->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
            ->_addBreadcrumb($this->__('abandonedorder'), $this->__('Abandoned'));

        return $this;
    }

    /**
     *
     */
    public function exportCsvAction()
    {
        $fileName   = 'orders.csv';
        $grid       = $this->getLayout()->createBlock('ebizmarts_abandonedcart/adminhtml_abandonedmails_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName   = 'orders.xml';
        $grid       = $this->getLayout()->createBlock('ebizmarts_abandonedcart/adminhtml_abandonedmails_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    /**
     *
     */
    public function gridAction()
    {
        $this->loadLayout(false);
        $this->renderLayout();
    }

    /**
     *
     */
}
