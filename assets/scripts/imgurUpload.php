<?php
/*
* Simple OO PHP wrapper for anonymous Imgur uploads
* Author: Trevor Wagner
* License: MIT
* 
*/

class imgurUpload {

  public $client_id;
  public $imgur_endpoint = 'https://api.imgur.com/3/upload.json';
  public $image_attr;
  public $allowed_mime_types;
  public $max_image_size;
  public $response_data;

  /**
   * Imgur Client ID
   *
   * Calling this method sets Imgur Client Id for basic request
   *
   * @param str $id
   *    client id received from registering an application with imgur
   *
   */
  public function set_client_key( $id ){
    $matchId = preg_match( '/^[A-Za-z0-9]*$/', $id );
    if( !empty( $id ) && $matchId >= 1 ){
      $this->client_id = $id;
    } else {
      throw new Exception("client id contains a non-alphanumeric character");
    }
  }


  /**
   * Image attributes array
   *
   * Passing this method an array of image attributes will set all properties to an object
   *
   * @param array $imgattr
   *    This can be an array from a multipart form, or an array built from a form that accepts a URL and image details
   *
   * @return object $image_attr
   */
  public function set_image_attributes( $imgattr = array() ){
    $this->image_attr = (object) $imgattr;
    return $this->image_attr;
  }


  /**
   * MIME Types allowed in upload form
   *
   * Passing this method an array of image attributes will set all properties to an object
   *
   * @param array $mimeTypes
   *    An array of mime types in the format 'image/*' allowed by your application's script
   */
  public function set_allowed_mime_types( $mimeTypes ){
    $this->allowed_mime_types = $mimeTypes;
  }


  /**
   * Check MIME type of a specific image
   *
   * Pass this method any mime type string in the format image/* to check if it is allowed
   *
   * @param str $type
   *    A string defining a mime type
   *
   * @return boolean
   *	  Returns true if mime type is allowed, False if not allowed
   */
  public function check_mime_types( $type ){
    $mimes = $this->allowed_mime_types;
    if(in_array($type, $mimes)){
        return true;
    } else {
       return false;
    }
  }


  /**
   * Set the maximum file size for uploads
   *
   * Pass this method a int of maximum file size in kilobytes
   *
   * @param int $args
   *    An int of filesize in kilobytes
   */
  public function set_max_file_size( $args ){
    $this->max_image_size = $args;
  }


  /**
   * Check file upload for compliance for max file size
   *
   * Pass this method a int of file size of an image to check it against the file size allowed
   *
   * @param int $filesize
   *    An int of filesize in kilobytes
   *
   * @return boolean true
   *	  Returns true if image is less than allowed file size
   *
   */
  public function check_image_file_size( $filesize ){
    if( $filesize <= $this->max_image_size ){
      return true;
    } else {
      return false;
    }
  }


  /**
   * Get image file contents, then base64 encode file stream
   *
   * @param object $image
   *	  Pass this method an image object defined in imgurUpload class
   *
   */
  public function encode_image( $image ){
    if( is_object( $image ) && $image->tmp_name != '' ){
      return base64_encode(file_get_contents($image->tmp_name));
    } else {
      throw new Exception('No image data received');
    }
  }


  /**
   * Set cURL request options
   *
   * @param object $curlHandle
   *
   * @param object $image
   *
   *
   *
   */
  public function set_curl_options( $curlHandle, $image ){
    curl_setopt($curlHandle, CURLOPT_URL, $this->imgur_endpoint );
    curl_setopt($curlHandle, CURLOPT_POST, TRUE);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array( 'Authorization: Client-ID ' . $this->client_id ));
    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array( 'image' => $image ));
  }


  /**
   * Set cURL request options
   *
   * @param json Object $curlReply
   *
   * @param string $returnType
   *		Type of data to return. Can be a string of 'json' or 'object'
   *
   * @return $data
   *
   *
   */
  public function handle_curl_response( $curlReply, $returnType ){
    if( $curlReply ){
      if( $returnType == 'object' ){
        $this->response_data = (object) json_decode( $curlReply );
      } else {
        $this->response_data = $curlReply;
      }
    } else {
      $this->response_data = '{ }';
    }
    return $this->response_data;
  }

} // END IMGUR UPLOAD CLASS  ?>






