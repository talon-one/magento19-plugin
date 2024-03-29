<?php

class TalonOne_TalonOne_Model_Event implements \JsonSerializable
{
    protected $_profileId;
    protected $_sessionId;
    protected $_type;
    protected $_attributes;

    public function getProfileId()
    {
        return $this->_profileId;
    }

    public function setProfileId($profileId)
    {
        $this->_profileId = $profileId;
    }

    public function getSessionId()
    {
        return $this->_sessionId;
    }

    public function setSessionId($sessionId)
    {
        $this->_sessionId = $sessionId;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function setAttributes($attributes)
    {
        $this->_attributes = $attributes;
    }

    public function toArray()
    {
        return [
            'profileId' => $this->getProfileId(),
            'sessionId' => $this->getSessionId(),
            'type' => $this->getType(),
            'attributes' => $this->getAttributes(),
        ];
    }

    public function jsonSerialize()
    {
        return array_filter($this->toArray(), function ($val) {
            return isset($val);
        });
    }
}