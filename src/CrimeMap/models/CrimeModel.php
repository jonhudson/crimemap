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
        $lng1 = $userLng - (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lng2 = $userLng + (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lat1 = $userLat - (0.5 / 69);
        $lat2 = $userLat + (0.5 / 69);
        
        $sql = 'SELECT * FROM crime 
                WHERE lng BETWEEN :lng1 AND :lng2
                AND lat BETWEEN :lat1 AND :lat2';
        
        $params = array(
            ':lng1' => $lng1, 
            ':lng2' => $lng2, 
            ':lat1' => $lat1, 
            ':lat2' => $lat2
        );        
        
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
        $lng1 = $userLng - (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lng2 = $userLng + (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lat1 = $userLat - (0.5 / 69);
        $lat2 = $userLat + (0.5 / 69);
        
        $sql = 'SELECT * FROM crime 
                WHERE lng BETWEEN :lng1 AND :lng2
                AND lat BETWEEN :lat1 AND :lat2
                AND crime_type LIKE :category';
        
        $params = array(
            ':lng1' => $lng1, 
            ':lng2' => $lng2, 
            ':lat1' => $lat1, 
            ':lat2' => $lat2,
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
     * in each year, for a category
     * 
     * @param String $category
     * @param double $userLat
     * @param double $userLng
     * @return array crime count per month and year
     */
    public function getCrimeNumbersPerMonthInCat($category, $userLat, $userLng) {
          
        $lng1 = $userLng - (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lng2 = $userLng + (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lat1 = $userLat - (0.5 / 69);
        $lat2 = $userLat + (0.5 / 69);
        
        $sql = 'SELECT COUNT(*) AS count
                FROM (
                    SELECT id FROM crime 
                    WHERE lng BETWEEN :lng1 AND :lng2
                    AND lat BETWEEN :lat1 AND :lat2
                    AND month = :month
                    AND crime_type LIKE :category
                ) AS crimes';     
       
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
            '2011' => array(),
            '2012' => array(),
            '2013' => array()
        );
        
        foreach ($years as $year => &$yearVal) {
            foreach ($months as $month => &$monthVal) {
                $params = array(
                    ':lng1' => $lng1, 
                    ':lng2' => $lng2, 
                    ':lat1' => $lat1, 
                    ':lat2' => $lat2,
                    ':month' => $year . '-' . $month,
                    ':category' => '%' . $category . '%'
                );

                $result = $this->db->fetch($sql, $params);
                $monthVal = $result['count'];
            }
            $yearVal = $months;
        }
        
        return $years;
    }    
    
    /**
     * Returns an array containing crime count for each month
     * in each year
     * 
     * @param double $userLat
     * @param double $userLng
     * @return array crime count per month and year
     */
    public function getCrimeNumbersPerMonth($userLat, $userLng) {
        
        $lng1 = $userLng - (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lng2 = $userLng + (0.5 / abs(cos(deg2rad($userLat)) * 69));
        $lat1 = $userLat - (0.5 / 69);
        $lat2 = $userLat + (0.5 / 69);
        
        $sql = 'SELECT COUNT(*) AS count
                FROM (
                    SELECT id FROM crime 
                    WHERE lng BETWEEN :lng1 AND :lng2
                    AND lat BETWEEN :lat1 AND :lat2
                    AND month = :month
                ) AS crimes';     
       
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
            '2011' => array(),
            '2012' => array(),
            '2013' => array()
        );
        
        foreach ($years as $year => &$yearVal) {
            foreach ($months as $month => &$monthVal) {
                $params = array(
                    ':lng1' => $lng1, 
                    ':lng2' => $lng2, 
                    ':lat1' => $lat1, 
                    ':lat2' => $lat2,
                    ':month' => $year . '-' . $month
                );

                $result = $this->db->fetch($sql, $params);
                $monthVal = $result['count'];
            }
            $yearVal = $months;
        }
        
        return $years;
    }    
}
