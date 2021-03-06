<?php

namespace Extensa\Careers\Block\Adminhtml\Positions\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
use Extensa\Careers\Block\Adminhtml\Positions\Edit\Tab\General;

class Tabs extends WidgetTabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('positions_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Position'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'general_data',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    General::class
                )->toHtml(),
                'active' => true
            ]
        );
        return parent::_beforeToHtml();
    }
}
