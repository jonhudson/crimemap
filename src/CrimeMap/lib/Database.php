<?php

namespace CrimeMap\lib;

class Database Extends \PDO 
{
    public function __construct($host, $name, $username, $password)
    {
        $dsn = 'mysql:dbname=' . $name . ';host=' . $host;

        try {
            parent::__construct($dsn, $username, $password);
        } catch (PDOException $e) {
            die('Could not connect to database' . $e);
        }
    }   
    
    
    /**
     * Fetch a row
     * 
     * @param string $sql
     * @param array $params
     * 
     * @return array
     * @throws \Exception
     */
    public function fetch($sql, Array $params)
    {
        $stmt = $this->prepare($sql);          
        $keysAndVals = array();
        
        foreach ($params as $key => $val) {
            $pdoType = gettype($val) == 'integer' ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $keysAndVals[] = array('key' => $key, 'val' => $val, 'type' => $pdoType);
        }
        
        foreach ($keysAndVals as $elem) {            
            $stmt->bindParam($elem['key'], $elem['val'], $elem['type']);
        }
        
        if ($stmt) {            
            $result = $stmt->execute();             
            if ($result) {
                return $stmt->fetch(\PDO::FETCH_ASSOC); 
            } else {
                $error = $stmt->errorInfo();
                throw new \Exception("Database error: " . $error[2]);
            }                     
        }
    }
    
    
    /**
     * Fetch all rows
     * 
     * @param string  $sql
     * @param array $params
     * 
     * @return array
     * @throws \Exception
     */
    public function fetchAll($sql, Array $params)
    {
        $stmt = $this->prepare($sql);  
        $keysAndVals = array();
        
        foreach ($params as $key => $val) {
            $pdoType = gettype($val) == 'integer' ? \PDO::PARAM_INT : \PDO::PARAM_STR;
            $keysAndVals[] = array('key' => $key, 'val' => $val, 'type' => $pdoType);
        }
        
        foreach ($keysAndVals as $elem) {            
            $stmt->bindParam($elem['key'], $elem['val'], $elem['type']);
        }
        
        if ($stmt) {            
            $result = $stmt->execute();             
            if ($result) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC); 
            } else {
                $error = $stmt->errorInfo();
                throw new \Exception("Database error: " . $error[2]);
            }                     
        }
    }
    
}