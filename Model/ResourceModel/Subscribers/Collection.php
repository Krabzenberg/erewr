<?php

namespace Extensa\Careers\Model\ResourceModel\Subscribers;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Extensa\Careers\Model\Subscribers::class,
            \Extensa\Careers\Model\ResourceModel\Subscribers::class
        );
    }
}
