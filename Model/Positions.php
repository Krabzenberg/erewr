<?php

namespace Extensa\Careers\Model;

use Magento\Framework\Model\AbstractModel;

class Positions extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Extensa\Careers\Model\ResourceModel\Positions::class);
    }
}
