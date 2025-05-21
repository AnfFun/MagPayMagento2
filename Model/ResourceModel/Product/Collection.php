<?php
/**
 * Product collection
 *
 * @category  GingerPay
 * @package   GingerPay_Payment
 * @author    Developer
 * @copyright Copyright (c) 2023 GingerPay
 */
namespace GingerPay\Payment\Model\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use GingerPay\Payment\Model\Product as ProductModel;
use GingerPay\Payment\Model\ResourceModel\Product as ProductResource;

/**
 * Class Collection
 * @package GingerPay\Payment\Model\ResourceModel\Product
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'gingerpay_product_collection';

    /**
     * Initialize collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ProductModel::class, ProductResource::class);
    }
}