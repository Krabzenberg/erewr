<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Extensa\Careers\Model;

use Magento\Framework\Model\AbstractModel;

class Subscribers extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init(\Extensa\Careers\Model\ResourceModel\Subscribers::class);
    }
}
