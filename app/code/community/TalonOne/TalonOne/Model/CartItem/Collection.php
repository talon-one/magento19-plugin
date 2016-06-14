<?php

class TalonOne_TalonOne_Model_CartItem_Collection implements \JsonSerializable
{
    protected $_items = array();

    public function count()
    {
        return count($this->_items);
    }

    public function getItems()
    {
        return $this->_items;
    }

    public function setItems($items)
    {
        $this->_items = $items;
    }

    public function hasItems()
    {
        return count($this->_items) > 0;
    }

    public function addItem(TalonOne_TalonOne_Model_CartItem $item)
    {
        array_push($this->_items, $item);
    }

    public function toArray()
    {
        return $this->_items;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}