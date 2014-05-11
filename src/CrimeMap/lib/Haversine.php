<?php
namespace CrimeMap\lib;

class Haversine 
{
    const EARTHS_RADIUS = 3959;
    
    public function getDistanceInMiles($latFrom, $lngFrom, $latTo, $lngTo)
    {
        $latFrom = deg2rad( (double) $latFrom);
        $lngFrom = deg2rad( (double) $lngFrom);
        $latTo = deg2rad( (double) $latTo);
        $lngTo = deg2rad( (double) $lngTo);
        
        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;
        
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));
        
        return round($angle * self::EARTHS_RADIUS, 1); 
    }   
    
}
