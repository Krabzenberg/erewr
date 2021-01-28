<?php

namespace Extensa\Careers\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Extensa\Careers\Model\PositionsFactory;
use Extensa\Careers\Model\CardsFactory;

class CareersHome extends Template
{
    private $scopeConfig;
    private $positionsFactory;
    private $cardsFactory;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        PositionsFactory $positionsFactory,
        CardsFactory $cardsFactory,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->positionsFactory = $positionsFactory;
        $this->cardsFactory = $cardsFactory;

        parent::__construct($context);
    }

    public function getPositionsCollection()
    {
        return $this->positionsFactory->create()->getCollection()
            ->addFieldToFilter('status', 1)->setOrder('position_id', 'desc');
    }

    public function getCardsCollection()
    {
        return $this->cardsFactory->create()
            ->getCollection()
            ->addFieldToFilter('status', 1)
            ->setOrder('card_id', 'desc')
            ->setPageSize(10)->load();
    }

    public function getTitle()
    {
        return $this->scopeConfig->getValue('extensa_careers/settings/title', ScopeInterface::SCOPE_STORE);
    }

    public function getFormAction()
    {
        return $this->getUrl('careers/career/newsubscriber', ['_secure' => true]);
    }
}
