<?php

namespace Extensa\Careers\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class PostActions extends Column
{
    const EDIT_CARD = 'careers/cards/edit';
    const DELETE_CARD = 'careers/cards/delete';
    const EDIT_POSITION = 'careers/positions/edit';
    const DELETE_POSITION = 'careers/positions/delete';
    const EDIT_SUBSCRIBER = 'careers/subscribers/edit';
    const DELETE_SUBSCRIBER = 'careers/subscribers/delete';
    protected $urlBuilder;
    private $editUrlCard;
    private $deleteUrlCard;
    private $editUrlPosition;
    private $deleteUrlPosition;
    private $editUrlSubscriber;
    private $deleteUrlSubscriber;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrlCard = self::EDIT_CARD,
        $deleteUrlCard = self::DELETE_CARD,
        $editUrlPosition = self::EDIT_POSITION,
        $deleteUrlPosition = self::DELETE_POSITION,
        $editUrlSubscriber = self::EDIT_SUBSCRIBER,
        $deleteUrlSubscriber = self::DELETE_SUBSCRIBER
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrlCard = $editUrlCard;
        $this->deleteUrlCard = $deleteUrlCard;
        $this->editUrlPosition = $editUrlPosition;
        $this->deleteUrlPosition = $deleteUrlPosition;
        $this->editUrlSubscriber = $editUrlSubscriber;
        $this->deleteUrlSubscriber = $deleteUrlSubscriber;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                if (isset($item['card_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl($this->editUrlCard, ['id' => $item['card_id']]),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl($this->deleteUrlCard, ['id' => $item['card_id']]),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                            ]
                        ]
                    ];
                }

                if (isset($item['position_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder
                                ->getUrl($this->editUrlPosition, ['id' => $item['position_id']]),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder
                                ->getUrl($this->deleteUrlPosition, ['id' => $item['position_id']]),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                            ]
                        ]
                    ];
                }

                if (isset($item['subscriber_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder
                                ->getUrl($this->editUrlSubscriber, ['id' => $item['subscriber_id']]),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder
                                ->getUrl($this->deleteUrlSubscriber, ['id' => $item['subscriber_id']]),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record?')
                            ]
                        ]
                    ];
                }

            }
        }

        return $dataSource;
    }
}
