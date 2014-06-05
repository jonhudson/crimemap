<?php

namespace CrimeMap\lib;

class StatsHelper {
    
    /**
     * Compares two numbers and returns the percentage difference
     * and whether increase or decrease.
     * 
     * @param int $num1 
     * @param int $num2
     * @return array
     */
    public function getPercentageChange($num1, $num2) 
    {           
        if ($num1 > $num2) {   
            $change = $num1 - $num2;
            $direction = 'decrease';
        } else if ($num2 > $num1) {
            $change = $num2 - $num1;
            $direction = 'increase';
        } else {
            $change = 0;
            $direction = 'no change';
        }
        $percentageChange = ($change / $num1) * 100; 
        
        return array('direction' => $direction, 'percentage' => $percentageChange);        
    }
}