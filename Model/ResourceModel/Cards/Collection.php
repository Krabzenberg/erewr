<?php

namespace Extensa\Careers\Model\ResourceModel\Cards;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Extensa\Careers\Model\Cards::class,
            \Extensa\Careers\Model\ResourceModel\Cards::class
        );
    }
}
