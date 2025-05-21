<?php
/**
 * Product model class
 *
 * @category  GingerPay
 * @package   GingerPay_Payment
 * @author    Developer
 * @copyright Copyright (c) 2023 GingerPay
 */
namespace GingerPay\Payment\Model;

use Magento\Framework\Model\AbstractModel;
use GingerPay\Payment\Model\ResourceModel\Product as ProductResource;

/**
 * Class Product
 * @package GingerPay\Payment\Model
 */
class Product extends AbstractModel
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'gingerpay_product_model';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ProductResource::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData('entity_id');
    }

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    /**
     * Get price
     *
     * @return float|null
     */
    public function getPrice()
    {
        return $this->getData('price');
    }

    /**
     * Set price
     *
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        return $this->setData('price', $price);
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData('description');
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData('description', $description);
    }
}