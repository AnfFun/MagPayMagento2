<?php
/**
 * Product controller
 *
 * @category  GingerPay
 * @package   GingerPay_Payment
 * @author    Developer
 * @copyright Copyright (c) 2023 GingerPay
 */
namespace GingerPay\Payment\Controller\Product;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use GingerPay\Payment\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class Index
 * @package GingerPay\Payment\Controller\Product
 */
class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('GingerPay Products'));
        
        return $resultPage;
    }
}