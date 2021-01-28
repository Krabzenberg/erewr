<?php

namespace Extensa\Careers\Controller\Adminhtml\Positions;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Positions;

class Delete extends Action
{
    protected $positionsModel;

    public function __construct(
        Action\Context $context,
        Positions $positionsModel
    ) {
        parent::__construct($context);
        $this->positionsModel = $positionsModel;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::positions');
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
                $model = $this->positionsModel;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Position deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Position does not exist'));

        return $resultRedirect->setPath('*/*/');
    }
}
