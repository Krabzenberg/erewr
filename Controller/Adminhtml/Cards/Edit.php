<?php

namespace Extensa\Careers\Controller\Adminhtml\Cards;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Magento\Backend\Model\Session;
use Extensa\Careers\Model\Cards;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $cardsModel;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Session $session,
        Cards $cardsModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->cardsModel = $cardsModel;
        $this->session = $session;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Extensa_Careers::cards')
            ->addBreadcrumb(__('Career'), __('Career'))
            ->addBreadcrumb(__('Cards'), __('Cards'))
            ->addBreadcrumb(__('Edit'), __('Edit'));

        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->cardsModel;

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

        $this->_coreRegistry->register('card_item', $model);
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Career'));
        $resultPage->getConfig()->getTitle()->prepend(__('Cards'));
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Edit'));

        return $resultPage;
    }
}
