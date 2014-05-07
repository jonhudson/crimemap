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
    
    public function fetch($sql, Array $params)
    {
        $stmt = $this->prepare($sql);        
        if ($stmt) {            
            $result = $stmt->execute($params);             
            if ($result) {
                return $stmt->fetch(\PDO::FETCH_ASSOC); 
            } else {
                $error = $stmt->errorInfo();
                throw new \Exception("Database error: " . $error[2]);
            }                     
        }
    }
    
    public function fetchAll($sql, Array $params)
    {
        $stmt = $this->prepare($sql);        
        if ($stmt) {            
            $result = $stmt->execute($params);             
            if ($result) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC); 
            } else {
                $error = $stmt->errorInfo();
                throw new \Exception("Database error: " . $error[2]);
            }                     
        }
    }
    
}