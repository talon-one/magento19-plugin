<?php

class TalonOne_TalonOne_Model_CartItem implements \JsonSerializable
{
    protected $_name;
    protected $_sku;
    protected $_quantity;
    protected $_currency;
    protected $_price;
    protected $_category;
    protected $_weight;
    protected $_height;
    protected $_width;
    protected $_length;

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getSku()
    {
        return $this->_sku;
    }

    public function setSku($sku)
    {
        $this->_sku = $sku;
    }

    public function getQuantity()
    {
        return $this->_quantity;
    }

    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function setPrice($price)
    {
        $this->_price = $price;
    }

    public function getCategory()
    {
        return $this->_category;
    }

    public function setCategory($category)
    {
        $this->_category = $category;
    }

    public function getWeight()
    {
        return $this->_weight;
    }

    public function setWeight($weight)
    {
        $this->_weight = $weight;
    }

    public function getHeight()
    {
        return $this->_height;
    }

    public function setHeight($height)
    {
        $this->_height = $height;
    }

    public function getWidth()
    {
        return $this->_width;
    }

    public function setWidth($width)
    {
        $this->_width = $width;
    }

    public function getLength()
    {
        return $this->_length;
    }

    public function setLength($length)
    {
        $this->_length = $length;
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'sku' => $this->getSku(),
            'quantity' => $this->getQuantity(),
            'currency' => $this->getCurrency(),
            'price' => $this->getPrice(),
            'category' => $this->getCategory(),
            'weight' => $this->getWeight(),
            'height' => $this->getHeight(),
            'width' => $this->getWidth(),
            'length' => $this->getLength(),
        ];
    }

    public function jsonSerialize()
    {
        return array_filter($this->toArray(), function ($val) {
            return isset($val);
        });
    }
}