<?php

namespace CrimeMap\lib;

interface DatabaseInterface 
{
    
    public function fetch($sql, $params = array());
    
    public function fetchAll($sql, $params = array());
    
}
