<?php

class TalonOne_TalonOne_Test_Model_Event extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @test
     * @covers TalonOne_TalonOne_Model_Event::setValue
     * @covers TalonOne_TalonOne_Model_Event::setProfileId
     * @covers TalonOne_TalonOne_Model_Event::setSessionId
     * @covers TalonOne_TalonOne_Model_Event::setType
     * @covers TalonOne_TalonOne_Model_Event::getValue
     * @covers TalonOne_TalonOne_Model_Event::getProfileId
     * @covers TalonOne_TalonOne_Model_Event::getSessionId
     * @covers TalonOne_TalonOne_Model_Event::getType
     * @covers TalonOne_TalonOne_Model_Event::toArray
     * @covers TalonOne_TalonOne_Model_Event::jsonSerialize
     */
    public function testEventBuild()
    {
        $e = new TalonOne_TalonOne_Model_Event();
        $e->setValue('test_value');
        $e->setProfileId('pid_id');
        $e->setSessionId('sid');
        $e->setType('test_type');

        $testArray = array(
            'profileId' => $e->getProfileId(),
            'sessionId' => $e->getSessionId(),
            'type' => $e->getType(),
            'value' => $e->getValue()
        );

        $this->assertEquals($e->getValue(), 'test_value');
        $this->assertEquals($e->getProfileId(), 'pid_id');
        $this->assertEquals($e->getSessionId(), 'sid');
        $this->assertEquals($e->getType(), 'test_type');

        $this->assertEquals($e->toArray(), $testArray);
        $this->assertEquals($e->jsonSerialize(), $testArray);

    }
}