<?php

namespace Extensa\Careers\Controller\Adminhtml\Subscribers;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Extensa\Careers\Model\Subscribers;
use Magento\Backend\Model\Session;

class Save extends Action
{
    protected $session;
    protected $subscribersModel;

    public function __construct(
        Context $context,
        Subscribers $subscribersModel,
        Session $session
    ) {
        parent::__construct($context);
        $this->session = $session;
        $this->subscribersModel = $subscribersModel;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->subscribersModel;
        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccess(__('Saved.'));

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }

            $this->session->setFormData(false);
            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong.'));
        }

        $this->_getSession()->setFormData($data);

        return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::subscribers');
    }
}
