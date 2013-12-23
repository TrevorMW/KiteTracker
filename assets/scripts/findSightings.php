<?php include_once('../../functions.php');

$data = $_GET;
$tRlat =  $data['tRlat'];
$tRlng =  $data['tRlng'];
$bLlat =  $data['bLlat'];
$bLlng =  $data['bLlng'];

$conn = connect_db();

$q = "SELECT * FROM `kt_fullSightings` WHERE `latitude` < '".$tRlat."' AND `latitude` > '".$bLlat."'AND `longitude` < '".$tRlng."' AND `longitude` > '".$bLlng."'";
 
$query = $conn->query($q);
  
if($query){
  $returnData = array();
	foreach($query as $q){ 
		$returnData[] = $q;
	}
	$returnData = json_encode($returnData);
echo $returnData;
} ?>