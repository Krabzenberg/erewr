<?php

namespace Extensa\Careers\Block\Adminhtml\Cards\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;

class General extends Generic implements TabInterface
{
    protected $_wysiwygConfig;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        array $data = []
    ) {
        $this->wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('card_item');
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General')]
        );

        if ($model->getId()) {
            $fieldset->addField(
                'card_id',
                'hidden',
                ['name' => 'card_id']
            );
        }

        if ($model->hasImage()) {
            $fieldset->addField(
                'thumbnail',
                'note',
                [
                    'name' => 'thumbnail',
                    'label' => __(''),
                    'required' => false,
                    'note' => '<div>
						<a href="' . $model->getImageUrl() . '" target="_blank">
							<img src="' . $model->getImageUrl() . '" style="max-height:100px" />
						</a>
					</div>'
                ]
            );
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'required' => false
            ]
        );

        $wysiwygConfig = $this->wysiwygConfig->getConfig();
        $fieldset->addField(
            'description',
            'editor',
            [
                'name' => 'description',
                'label' => __('Description'),
                'required' => false,
                'style' => 'height: 15em; width: 100%;',
                'config' => $wysiwygConfig
            ]
        );

        $fieldset->addField(
            'position',
            'text',
            [
                'name' => 'position',
                'label' => __('Position'),
                'required' => false
            ]
        );

        $fieldset->addField(
            'image',
            'file',
            [
                'name' => 'image',
                'label' => __('Image'),
                'required' => false,
                'note' => 'Allow image type: jpg, jpeg, png'
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
                    ['value' => "1", 'label' => __('Active')],
                    ['value' => "0", 'label' => __('Not Active')]
                ]
            ]
        );

        if (!$model->getData('sort_order')) {
            $model->setData('sort_order', "0");
        }

        $fieldset->addField(
            'sort_order',
            'text',
            [
                'name' => 'sort_order',
                'label' => __('Sort Order'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'favorite_products',
            'text',
            [
                'name' => 'favorite_products',
                'label' => __('Favorite Products'),
                'required' => true
            ]
        );
        $data = $model->getData();
        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Card');
    }

    public function getTabTitle()
    {
        return __('Card');
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
