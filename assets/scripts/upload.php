<?php include_once('imgurUpload.php');

$imageData = $_FILES['images'];

$mimes = array('image/jpeg','image/jpg','image/gif','image/png');

$upload = new imgurUpload();
$upload->set_client_key('9c616d70834d15a');
$upload->set_image_attributes($imageData);
$upload->set_allowed_mime_types($mimes);
$upload->set_max_file_size(1500);
$mimeCheck = $upload->check_mime_types( $upload->image_attr->type );
$sizeCheck = $upload->check_image_file_size( $upload->image_attr->type );
$encodedImage = $upload->encode_image( $upload->image_attr );

if( $mimeCheck == true && $sizeCheck == true ){
  $curl = curl_init();
  $upload->set_curl_options( $curl, $encodedImage );
  $curl = curl_exec($curl);
  $curlResponse = $upload->handle_curl_response( $curl, 'json' );
  if( $curlResponse ){
    echo $curlResponse;
  }
}



