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
     * Gets $limit records from db starting from $fromId
     * 
     * @param int $limit
     * @param int $fromId
     * 
     * @return array The first element contains last id plus one, second element contains data
     */
    public function getCrimesInBatches($limit, $fromId)
    {
        $sql = 'SELECT * FROM crime WHERE id >= :fromId LIMIT :limit';
        $params = array(':fromId' => $fromId, ':limit' => $limit);        
        $data = $this->db->fetchAll($sql, $params);
        $lastElem = $data[count($data) - 1];
        
        if (!empty($data)) {
            return array('nextId' => $lastElem['id'] + 1, 'crimeData' => $data);
        }
        
        return false;        
    }
}
