<?php

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
        $expected = array('direction' => 'decrease', 'percentage' => 50);
        
        $result = $this->statsHelperMock->getPercentageChange($num1, $num2);        
        $this->assertEquals($expected['direction'], $result['direction']);
        $this->assertEquals($expected['percentage'], $result['percentage']);
    }
    
    public function testGetPercentageChangeReturnsIncrease() 
    {
        $num1 = 10;
        $num2 = 12;
        $expected = array('direction' => 'increase', 'percentage' => 20);
        
        $result = $this->statsHelperMock->getPercentageChange($num1, $num2);        
        $this->assertEquals($expected['direction'], $result['direction']);
        $this->assertEquals($expected['percentage'], $result['percentage']);
    }
    
    public function testGetPercentageChangeReturnsZero() 
    {
        $num1 = 10;
        $num2 = 10;
        $expected = array('direction' => 'no change', 'percentage' => 0);
        
        $result = $this->statsHelperMock->getPercentageChange($num1, $num2);        
        $this->assertEquals($expected['direction'], $result['direction']);
        $this->assertEquals($expected['percentage'], $result['percentage']);
    }
}
