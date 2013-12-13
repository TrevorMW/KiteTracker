<?php //print_r($_FILES);

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
}

?>