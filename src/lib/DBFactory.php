<?php
namespace CrimeMap\lib;

use CrimeMap\lib\MySQLDB;
use CrimeMap\Config;

class DBFactory 
{    
    /**
     * 
     * @param string $vendor
     * @return \CrimeMap\MySQLDB
     * @throws \InvalidArgumentException
     */
    public static function createDB($vendor) 
    {
        if ($vendor == 'mysql') {
            return new MySQLDB(Config::DB_HOST, Config::DB_NAME, Config::DB_USERNAME, Config::DB_PASSWORD);
        }
        
        throw new \InvalidArgumentException('Invalid database vendor given');
    }
}
