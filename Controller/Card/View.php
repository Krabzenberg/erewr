<?php

namespace Extensa\Careers\Controller\Card;

use Extensa\Careers\Model\Cards;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Magento\Backend\Model\Session;

class View extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
    protected $cardsModel;
    protected $session;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Registry $registry,
        Cards $cardsModel,
        Session $session
    ) {
        $this->cardsModel = $cardsModel;
        $this->session = $session;
        $this->_pageFactory = $pageFactory;
        $this->_coreRegistry = $registry;

        return parent::__construct($context);
    }

    public function execute()
    {

        $id = $this->getRequest()->getParam('id');
        $model =  $this->cardsModel;

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
        $resultPage = $this->_pageFactory->create();

        return $resultPage;
    }
}
