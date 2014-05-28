<?php

namespace CrimeMap\models;

class CrimeModel 
{
    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    /**
     * Fetches crimes within 1 mile of user's latitude and longitude
     * 
     * @param double $userLat
     * @param double $userLng
     * 
     * @return array The crime data
     */
    public function getCrimes($userLat, $userLng)
    {
        $sql = 'SELECT *, ( 3959 * acos( cos( radians(:userLat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(:userLng) ) + sin( radians(:userLat) ) * sin( radians( lat ) ) ) ) 
                AS distance 
                FROM crime 
                HAVING distance <= 1';
        
        $params = array(':userLat' => $userLat, ':userLng' => $userLng);        
        
        return $this->db->fetchAll($sql, $params);
               
    }
    
    /**
     * Fetches crimes within 1 mile of user's latitude and longitude
     * that are of type $category
     * 
     * @param string $category
     * @param double $userLat
     * @param double $userLng
     * 
     * @return array The crime data
     */
    public function getCrimesInCategory($category, $userLat, $userLng)
    {
        $sql = 'SELECT *, ( 3959 * acos( cos( radians(:userLat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(:userLng) ) + sin( radians(:userLat) ) * sin( radians( lat ) ) ) ) 
                AS distance 
                FROM crime 
                WHERE crime_type LIKE :category
                HAVING distance <= 1';               
        
        $params = array(
            ':userLat' => $userLat, 
            ':userLng' => $userLng,
            ':category' => '%' . $category . '%'
        );        
        
        return $this->db->fetchAll($sql, $params);
    }
    
    
    public function getCategories()
    {
        $sql = 'SELECT DISTINCT crime_type 
                FROM crime
                ORDER BY crime_type ASC';
        
        return $this->db->fetchAll($sql);
    }
    
    /**
     * Returns an array containing crime count for each month
     * in each year.
     * 
     * @param String $category
     * @param double $userLat
     * @param double $userLng
     * @return array crime count per month and year
     */
    public function getCrimeNumbersPerMonth($category, $userLat, $userLng) {
        
        $sql = 'SELECT COUNT(id) AS count, ( 3959 * acos( cos( radians(:userLat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(:userLng) ) + sin( radians(:userLat) ) * sin( radians( lat ) ) ) ) 
                AS distance 
                FROM crime 
                WHERE crime_type like :category
                AND WHERE month = :month
                HAVING distance <= 1';  
       
        $months = array(
            '01' => 0,
            '02' => 0,
            '03' => 0,
            '04' => 0,
            '05' => 0,
            '06' => 0,
            '07' => 0,
            '08' => 0,
            '09' => 0,
            '10' => 0,
            '11' => 0,
            '12' => 0            
        );
        
        $years = array(
            '2012' => '',
            '2013' => ''
        );
        
        foreach ($years as $year => &$yearVal) {
            foreach ($months as $month => &$monthVal) {
                $params = array(
                    ':userLat' => $userLat, 
                    ':userLng' => $userLng,
                    ':category' => '%' . $category . '%',
                    ':month' => $year . '-' . $month
                );

                $result = $this->db->fetchAll($sql, $params);
                $monthVal = $result['count'];
            }
            $yearVal = $months;
        }
        
        return $years;
    }    
}
