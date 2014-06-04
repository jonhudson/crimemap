<?php

namespace CrimeMap\tests;

use CrimeMap\lib\StatsHelper;

class StatsHelperTest extends \PHPUnit_Framework_TestCase {
    
    private $statsHelperMock;
    
    public function setUp() 
    {
        $this->statsHelperMock = new StatsHelper;
    }
    
    public function testGetPercentageChangeReturnsDecrease() 
    {
        $num1 = 10;
        $num2 = 5;
        $expected = array('direction' => 'down', 'percentage' => 50);
        
        $result = $this->statsHelperMock->getPercentageChange($num1, $num2);        
        $this->assertEquals($expected['direction'], $result['direction']);
        $this->assertEquals($expected['percentage'], $result['percentage']);
    }
}
