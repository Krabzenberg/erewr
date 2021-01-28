<?php

namespace Extensa\Careers\Model\ResourceModel;

class Positions extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('extensa_careers_position', 'position_id');
    }
}
