<?php

namespace Extensa\Careers\Block\Adminhtml\Subscribers\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;
use \Extensa\Careers\Block\Adminhtml\Subscribers\Edit\Tab\General;

class Tabs extends WidgetTabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('subscribers_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Subscriber'));
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
