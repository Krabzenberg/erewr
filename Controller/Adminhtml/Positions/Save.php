<?php

namespace Extensa\Careers\Controller\Adminhtml\Positions;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Extensa\Careers\Model\Positions;
use Magento\Backend\Model\Session;

class Save extends Action
{
    protected $session;
    protected $positionsModel;

    public function __construct(
        Context $context,
        Positions $positionsModel,
        Session $session
    ) {
        parent::__construct($context);
        $this->positionsModel = $positionsModel;
        $this->session = $session;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->positionsModel;

        try {
            $model->setData($data)->save();
            $this->messageManager->addSuccess(__('Saved.'));

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }

            $this->session->setFormData(false);
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __($e->getMessage()));
        }

        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::positions');
    }
}
