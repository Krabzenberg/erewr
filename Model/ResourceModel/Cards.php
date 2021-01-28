<?php

namespace Extensa\Careers\Model\ResourceModel;

class Cards extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('extensa_careers_card', 'card_id');
    }
}
