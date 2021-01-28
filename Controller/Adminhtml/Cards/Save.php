<?php

namespace Extensa\Careers\Controller\Adminhtml\Cards;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Filesystem\DirectoryList;
use Extensa\Careers\Model\Cards;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Backend\Model\Session;
use Magento\Framework\Image\AdapterFactory;

class Save extends Action
{
    protected $directoryList;
    protected $cardsModel;
    protected $adapterFactory;
    protected $session;
    protected $uploaderFactory;

    public function __construct(
        Context $context,
        DirectoryList $directoryList,
        Cards $cardsModel,
        UploaderFactory $uploaderFactory,
        Session $session,
        AdapterFactory $adapterFactory
    ) {
        parent::__construct($context);
        $this->directoryList = $directoryList;
        $this->cardsModel = $cardsModel;
        $this->session = $session;
        $this->adapterFactory = $adapterFactory;
        $this->uploaderFactory = $uploaderFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $files = $this->getRequest()->getFiles()->toArray();

        $model = $this->cardsModel;
        $directory = $this->directoryList;
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $model->setData($data);

            if (isset($files['image']) && $files['image']['name'] != '') {
                $uploader = $this->uploaderFactory->create(['fileId' => 'image']);
                $uploader->setAllowCreateFolders(true);
                $uploader->setAllowedExtensions(['jpeg', 'jpg', 'png']);

                if ($uploader->save($directory->getRoot() . '/media/cards/' . $model->getId() . '/')) {
                    $filename = $uploader->getUploadedFileName();
                    $model->setData('image', '/media/cards/' . $model->getId() . '/' . $filename);
                    $this->resize($model->getData('image'));
                }
            }

            $model->save();

            $this->messageManager->addSuccess(__('Saved.'));

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }

            $this->session->setFormData(false);
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __($e->getMessage()));
        }

        return $resultRedirect->setPath('*/*/');
    }

    public function resize($image, $width = 50, $height = 50)
    {
        $filesystem = $this->directoryList;
        $absolutePath = $filesystem->getRoot() . $image;
        $imageResized = $filesystem->getRoot() . ('/resized/') . $image;
        //create image factory...
        $imageFactory = $this->adapterFactory;
        $imageResize = $imageFactory->create();
        $imageResize->open($absolutePath);
        $imageResize->constrainOnly(true);
        $imageResize->keepTransparency(true);
        $imageResize->keepFrame(false);
        $imageResize->keepAspectRatio(true);
        $imageResize->resize($width, $height);
        //destination folder
        $destination = $imageResized;
        //save image
        $imageResize->save($destination);

        return true;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Extensa_Careers::cards');
    }
}
