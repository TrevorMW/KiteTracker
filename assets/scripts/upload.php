<?php
/*
// DEFINE ANONYMOUS CLIENT ID
$client_id = "9c616d70834d15a";



if(isset($_FILES) && exclude_file_types() == true){ // IF FILE IS PRESENT, PASS IT ALONG TO IMGUR VIA API POST ENDPOINT

// GET FILE TEMPORARY NAME
$image = $_FILES['images']['tmp_name']; //var_dump($image);

// GET FILE CONTENTS TO CREATE SOMETHING TO ENCODE WITH BASE64
$image = file_get_contents($image);

// START CURL INITIATION AND PASS ALONG DATA AND OPTIONS
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/upload.json');
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Authorization: Client-ID ' . $client_id ));
curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));

// EXECUTE CURL REQUEST TO IMGUR
$reply = curl_exec($ch); //var_dump($reply);

  // ECHO JSON OBJECT BACK TO AJAX TO USE
  echo $reply;

// CLOSE CURL CONNECTION curl_close($ch);



} else {
  $output = array('success' => 'false', 'status '=> '404', 'message' => 'Imgur could not upload this image, please try again.');
  $output = json_encode($output);
  echo $output;
}

function exclude_file_types(){
  $fileType = $_FILES['images']['type'];
  switch ($fileType) {
    case 'image/png':$valid = true;break;
    case 'image/jpg':$valid = true;break;
    case 'image/jpeg':$valid = true;break;
    case 'image/gif':$valid = true;break;
    default: $valid = false;
  }
  return $valid;
} */

include_once('imgurUpload.php');

$imageData = $_FILES['images'];

$mimes = array('image/jpeg','image/jpg','image/gif','image/png');

$upload = new imgurUpload();
$upload->set_client_key('9c616d70834d15a');
$upload->set_image_attributes($imageData);
$upload->set_allowed_mime_types($mimes);
$upload->set_max_file_size(1500);
$mimeCheck = $upload->check_mime_types($upload->image_attr->type);
$sizeCheck = $upload->check_image_file_size($upload->image_attr->type);
$encodedImage = $upload->encode_image($upload->image_attr);

if($mimeCheck == true){
  $curl = curl_init();
  $upload->set_curl_options( $curl, $encodedImage );
  $curl = curl_exec($curl);
  $curlResponse = $upload->handle_curl_response( $curl, 'json' );
  if( $curlResponse ){
    echo $curlResponse;
  }

}

