<?php

namespace Extensa\Careers\Controller\Adminhtml\Subscribers;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Subscribers;
use Magento\Backend\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $subscribersModel;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Subscribers $subscribersModel,
        Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->session = $session;
        $this->subscribersModel = $subscribersModel;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::subscribers');
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Extensa_Careers::subscribers')
            ->addBreadcrumb(__('Career'), __('Career'))
            ->addBreadcrumb(__('Subscribers'), __('Subscribers'))
            ->addBreadcrumb(__('Edit'), __('Edit'));

        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->subscribersModel;

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->session->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('subscriber_item', $model);
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Career'));
        $resultPage->getConfig()->getTitle()->prepend(__('Subscribers'));
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Edit'));

        return $resultPage;
    }
}
