<?php

namespace Extensa\Careers\Controller\Adminhtml\Subscribers;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Subscribers;

class Delete extends Action
{
    protected $subscribersModel;

    public function __construct(
        Action\Context $context,
        Subscribers $subscribersModel
    ) {
        parent::__construct($context);
        $this->subscribersModel = $subscribersModel;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::subscribers');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->subscribersModel;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Subscriber deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Subscriber does not exist'));

        return $resultRedirect->setPath('*/*/');
    }
}
