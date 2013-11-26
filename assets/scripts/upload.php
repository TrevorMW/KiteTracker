<?php //print_r($_FILES);

function exclude_file_types(){
    $fileType = $_FILES['images']['type'];
    switch ($fileType) {
        case 'image/png':$valid = true;break;
        case 'image/jpg':$valid = true;break;
        case 'image/gif':$valid = true;break;
        default: $valid = false;
    }
    return $valid;
}

if(isset($_FILES) && exclude_file_types() == true){ // IF FILE IS PRESENT, PASS IT ALONG TO IMGUR VIA API POST ENDPOINT

// GET FILE TEMPORARY NAME
$image = $_FILES['images']['tmp_name'];

// GET FILE CONTENTS TO CREATE SOMETHING TO ENCODE WITH BASE64
$image = file_get_contents($image);

// DEFINE ANONYMOUS CLIENT ID
$client_id = "9c616d70834d15a";

// START CURL INITIATION AND PASS ALONG DATA AND OTIONS
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/upload.json');
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Authorization: Client-ID ' . $client_id ));
curl_setopt($ch, CURLOPT_POSTFIELDS, array( 'image' => base64_encode($image) ));

// EXECUTE CURL REQUEST TO IMGUR
$reply = curl_exec($ch);

// CLOSE CURL CONNECTION
curl_close($ch);

// ECHO JSON OBJECT BACK TO AJAX TO USE
echo $reply;

} else {
$output = array('success'=>false, 'status'=>'404' );
$output = json_encode($output);
    echo $output;
} ?>