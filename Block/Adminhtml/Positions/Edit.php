<?php

namespace Extensa\Careers\Block\Adminhtml\Positions;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry = null;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'position_id';
        $this->_blockGroup = 'Extensa_Careers';
        $this->_controller = 'adminhtml_positions';
        parent::_construct();

        if ($this->_isAllowedAction('Extensa_Careers::positions')) {
            $this->buttonList->remove('reset');
            $this->buttonList->update('save', 'label', __('Save Position'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('Extensa_Careers::positions')) {
            $this->buttonList->update('delete', 'label', __('Delete Position'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('position_item')->getId()) {
            return __(
                "Edit Position '%1'",
                $this->escapeHtml($this->_coreRegistry->registry('position_item')->getId())
            );
        } else {
            return __('New Position');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('career/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }

    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('general_content') == null) {
					tinyMCE.execCommand('mceAddControl', false, 'general_content');
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, 'general_content');
				}
			};
		";
        return parent::_prepareLayout();
    }
}
