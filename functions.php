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
      
			return $db; var_dump($db);
      	
             
    } catch(PDOException $e){  
        
        echo $e->getMessage(); 
         
    }  
		
	}
	
	
	
	function close_connection(){
		
		$db = null;
		
		echo 'Database Closed';
		
	}
	
	
}


function get_day_number($currentMonth){
    $currentMonth = strtolower($currentMonth);
    switch ($currentMonth){

        case 'september': $output = '30'; break;
        case 'april': $output = '30'; break;
        case 'june': $output = '30'; break;
        case 'november': $output = '30'; break;
        case 'february': $output = '28'; break;
        default: $output = '31';
    }

     return $output;

}


?>