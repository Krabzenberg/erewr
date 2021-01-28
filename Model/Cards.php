<?php

namespace Extensa\Careers\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;

class Cards extends AbstractModel
{
    protected $storeManager;
    protected $directoryList;
    protected $io;

    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        DirectoryList $directoryList,
        File $io
    ) {
        $this->storeManager = $storeManager;
        $this->directoryList = $directoryList;
        $this->io = $io;
        parent::__construct($context, $registry);
    }

    protected function _construct()
    {
        $this->_init(\Extensa\Careers\Model\ResourceModel\Cards::class);
    }

    public function afterDelete()
    {
        return $this->io->rmdir($this->directoryList->getRoot() . '/media/cards/' . $this->getData('id') . '/', true);
    }

    public function getStoreBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
    }

    public function getImageUrl()
    {
        return rtrim($this->getStoreBaseUrl(), '/') . '/resized/' . ltrim($this->getData('image'), '/');
    }

    protected function getImagePath()
    {
        return $this->directoryList->getRoot() . '/' . ltrim($this->getData('image'), '/');
    }

    public function existsImage()
    {
        return ($this->getImagePath());
    }

    public function hasImage()
    {
        return ((bool)$this->getData('image') !== false && $this->existsImage());
    }
}
