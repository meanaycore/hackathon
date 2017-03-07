<?php

class CurlCaller
{

    public static function call($method, $url, $data=FALSE, $httpHeaders=array(), $username='', $password='', $userAgent='Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)')
    {
        $curl = curl_init();
        
        switch (strtoupper($method))
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                
                if ($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                } else {
                    // Prevents 413 - Request Entity Too Large
                    curl_setopt($curl, CURLOPT_POSTFIELDS, array());
                }
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default: // GET
                if ($data){
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }
        
        $options = array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HEADER          => false, // true returns the Header info as a string
            CURLOPT_FOLLOWLOCATION  => false,
            CURLOPT_SSL_VERIFYHOST  => '0',
            CURLOPT_SSL_VERIFYPEER  => '0', // Ignore certificate warning
            CURLOPT_USERAGENT       => $userAgent,
            CURLOPT_VERBOSE         => true,
        );
        
        // Set HTTP Headers if set
        if (is_array($httpHeaders) && !empty($httpHeaders)) {
            $options[CURLOPT_HTTPHEADER] = $httpHeaders;
        }
        
        curl_setopt_array($curl, $options);
        
        if (!empty($username) && !empty($password)) {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "{$username}:{$password}");
        }
        
        //curl_setopt($curl, CURLOPT_URL, $url);
        
        return curl_exec($curl);
    }
}