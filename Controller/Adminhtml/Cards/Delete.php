<?php

namespace Extensa\Careers\Controller\Adminhtml\Cards;

use Magento\Backend\App\Action;
use Extensa\Careers\Model\Cards;

class Delete extends Action
{
    protected $cardsModel;

    public function __construct(
        Action\Context $context,
        Cards $cardsModel
    ) {
        parent::__construct($context);
        $this->cardsModel = $cardsModel;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::cards');
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
                $model = $this->cardsModel;
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Card deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addError(__('Card does not exist'));

        return $resultRedirect->setPath('*/*/');
    }
}
