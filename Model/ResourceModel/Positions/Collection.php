<?php

namespace Extensa\Careers\Model\ResourceModel\Positions;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Extensa\Careers\Model\Positions::class,
            \Extensa\Careers\Model\ResourceModel\Positions::class
        );
    }
}
