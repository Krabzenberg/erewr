<?php

namespace Extensa\Careers\Model\ResourceModel;

class Subscribers extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('extensa_careers_subscriber', 'subscriber_id');
    }
}
