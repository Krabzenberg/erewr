<?php

namespace Extensa\Careers\Block\Adminhtml\Positions\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;

class General extends Generic implements TabInterface
{
    protected $_wysiwygConfig;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        array $data = []
    ) {
        $this->wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('position_item');
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General')]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'position_id',
                'hidden',
                ['name' => 'position_id']
            );
        }

        $fieldset->addField(
            'position_name',
            'text',
            [
                'name' => 'position_name',
                'label' => __('Position Name'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'object_name',
            'text',
            [
                'name' => 'object_name',
                'label' => __('Object Name'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'description',
            'editor',
            [
                'rows' => '5',
                'cols' => '30',
                'wysiwyg' => true,
                'config' => $this->wysiwygConfig->getConfig(),
                'required' => true,
                'name' => 'description',
                'label' => __('Description'),
                'style' => 'height: 15em; width: 100%;',

            ]
        );

        $fieldset->addField(
            'short_description',
            'editor',
            [
                'rows' => '5',
                'cols' => '30',
                'wysiwyg' => true,
                'required' => true,
                'name' => 'short_description',
                'label' => __('Short Description'),
                'style' => 'height: 10em; width: 50%;',
                'config' => $this->wysiwygConfig->getConfig()
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name' => 'status',
                'label' => __('Status'),
                'required' => true,
                'values' => [
                    ['value' => "1", 'label' => __('Yes')],
                    ['value' => "0", 'label' => __('No')]
                ]
            ]
        );

        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Position');
    }

    public function getTabTitle()
    {
        return __('Position');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
