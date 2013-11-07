<?php

define('DB_HOST','localhost');
define('DB_NAME','trevor_SwallowTail');
define('DB_USER','trevor_raptor');
define('DB_PASS','hR-G!a%paUKi');

class Connection {
		
	function __construct(){
			
		try {  
		
			$hosts = 'mysql:host='.DB_HOST.';'; 
			$hosts .= 'dbname='.DB_NAME.'';
		
      $db = new PDO($hosts, DB_USER, DB_PASS);
             
    } catch(PDOException $e){  
        
        echo $e->getMessage(); 
         
    }  
		
	}
	
	
	
	function close_connection(){
		
		$db = null;
		
		echo 'Database Closed';
		
	}
	
	
}


?>