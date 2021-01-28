<?php

namespace Extensa\Careers\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Extensa\Careers\Model\PositionsFactory;
use Extensa\Careers\Model\CardsFactory;

class CardView extends Template
{
    private $positionsFactory;
    private $cardsFactory;

    public function __construct(
        Context $context,
        PositionsFactory $positionsFactory,
        CardsFactory $cardsFactory
    ) {
        $this->positionsFactory = $positionsFactory;
        $this->cardsFactory = $cardsFactory;

        parent::__construct($context);
    }

    public function getCard()
    {
        $id = $this->getRequest()->getParam('id');

        return $this->cardsFactory->create()->load($id);
    }

    public function getFormAction()
    {
        return $this->getUrl('careers/career/newcandidate', ['_secure' => true]);
    }
}
