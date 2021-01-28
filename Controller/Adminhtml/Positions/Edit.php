<?php

namespace Extensa\Careers\Controller\Adminhtml\Positions;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Positions;
use Magento\Backend\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $positionsModel;
    protected $session;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Positions $positionsModel,
        Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->session = $session;
        $this->positionsModel = $positionsModel;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::positions');
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Extensa_Careers::positions')
            ->addBreadcrumb(__('Career'), __('Career'))
            ->addBreadcrumb(__('Positions'), __('Positions'))
            ->addBreadcrumb(__('Edit'), __('Edit'));

        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->positionsModel;

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

        $this->_coreRegistry->register('position_item', $model);
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Career'));
        $resultPage->getConfig()->getTitle()->prepend(__('Positions'));
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Edit'));

        return $resultPage;
    }
}
