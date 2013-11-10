<?php 

// RANDOM DATA GENERATOR FOR COORDINATE POINTS IN SOUTH CAROLINA
$n = 100;
$i = 0;
$lipsum = simplexml_load_file('http://www.lipsum.com/feed/xml?amount=1&what=paras&start=0');
$lipsum = $lipsum->lipsum;
$lipsum = explode(' ',$lipsum); 
$lipsumCount = count($lipsum);

while($i < $n) {
$arrayValue = rand(1,$lipsumCount);
$latMain = rand(32, 34);
$latFloat = rand(10000, 90000);

$longMain = rand(79, 81);
$longFloat = rand(10000, 90000);

$year = rand(6,9);


    echo "('','".$lipsum[$arrayValue]."','200".$year."','".$latMain.'.'.$latFloat."', '-".$longMain.'.'.$longFloat."'),<br/>";


	


$i++; }; ?>