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
                HAVING distance <= 1
                WHERE crime = :category';
        
        $params = array(
            ':userLat' => $userLat, 
            ':userLng' => $userLng,
            ':category' => $category
        );        
        
        return $this->db->fetchAll($sql, $params);
    }
    
    
    public function getCategories()
    {
        $sql = 'SELECT DISTINCT crime 
                FROM crime
                ORDER BY crime ASC';
        
        return $this->db->fetchAll($sql);
    }
    
}
