<?php
/**
 * Product list block
 *
 * @category  GingerPay
 * @package   GingerPay_Payment
 * @author    Developer
 * @copyright Copyright (c) 2023 GingerPay
 */
namespace GingerPay\Payment\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use GingerPay\Payment\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class ProductList
 * @package GingerPay\Payment\Block\Product
 */
class ProductList extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get product collection
     *
     * @return \GingerPay\Payment\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToSelect('*');
        return $collection;
    }

    /**
     * Get formatted price
     *
     * @param float $price
     * @return string
     */
    public function getFormattedPrice($price)
    {
        return $this->_storeManager->getStore()->getBaseCurrency()->formatPrecision(
            $price,
            2,
            [],
            false
        );
    }
}