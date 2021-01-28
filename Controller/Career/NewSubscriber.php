<?php

namespace Extensa\Careers\Controller\Career;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Psr\Log\LoggerInterface;
use Extensa\Careers\Model\SubscribersFactory;
use Extensa\Careers\Model\Mail;

class NewSubscriber extends Action
{
    private $subscribers;
    private $logger;
    private $mail;

    public function __construct(
        Context $context,
        LoggerInterface $loggerInterface,
        SubscribersFactory $subscribers,
        Mail $mail,
        array $data = []
    ) {
        parent::__construct($context);
        $this->logger = $loggerInterface;
        $this->subscribers = $subscribers;
        $this->mail = $mail;
    }

    public function execute()
    {
        $post = $this->getRequest()->getParams();

        try {
            $subscriber = $this->subscribers->create()->setData($post)->save();
            $from = ['name' => '', 'email' => $post['email']];

            $this->mail->sendMail('subscriber', $from, $subscriber->getData());

            $this->messageManager->addSuccess(__('Email sent successfully.'));
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
            $this->messageManager->addError(__('Something went wrong.'));
        }

        $this->_redirect('careers/');
    }
}
