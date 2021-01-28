<?php

namespace Extensa\Careers\Model\Config\Source;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $options = [];
        $options[] = ['label' => 'Not Active', 'value' => '0'];
        $options[] = ['label' => 'Active', 'value' => '1'];
        return $options;
    }
}
