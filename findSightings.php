<?php 

define('DB_HOST','localhost');
define('DB_NAME','trevor_SwallowTail');
define('DB_USER','trevor_raptor');
define('DB_PASS','hR-G!a%paUKi');

$data = $_GET;
$tRlat =  $data['tRlat'];
$tRlng =  $data['tRlng'];
$bLlat =  $data['bLlat'];
$bLlng =  $data['bLlng'];

$returnData = array();

try {  
	$hosts = 'mysql:host='.DB_HOST.';'; 
	$hosts .= 'dbname='.DB_NAME.'';
	$db = new PDO($hosts, DB_USER, DB_PASS);
} catch(PDOException $e){  
    echo $e->getMessage(); 
}  

$q = "SELECT * FROM `kt_sightings` WHERE `lat` > '".$bLlat."' AND `lat` < '".$tRlat."' AND `long` < '".$tRlng."' AND `long` > '".$bLlng."'";
 
$query = $db->query($q);
  
if($query){ 
	foreach($query as $q){ 
		$returnData[] = $q;
	}
	$returnData = json_encode($returnData);
	echo $returnData;
} ?>