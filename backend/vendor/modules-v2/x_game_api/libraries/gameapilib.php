<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/14/14
 * Time: 2:03 PM
 */
class Gameapilib {

    private $ci;
    private $API_HOST 			= "http://dev.classcompete.com";

    public function __construct(){
        $this->ci = & get_instance();
//        $this->ci->load->helper('x_game_api/gameapihelper');
    }

    public function generateXML($documentName, $data){
        $xmlDoc = "";

        $xmlDoc .= sprintf("<?xml version='1.0'?>\n");

        $xmlDoc .= sprintf("<%s>\n", $documentName);

        foreach ($data as $name => $value)

            $xmlDoc .= sprintf("   <%s>%s</%s>\n", $name, $value, $name);

        $xmlDoc .= sprintf("</%s>\n", $documentName);

        return $xmlDoc;
    }

    public function  post($url, $headers, $body){

        return $this->sendHTTP($this->API_HOST . $url, "POST", $headers, $body);

    }

    private function sendHTTP($url, $method, $headers, $body){
        $handle = curl_init();

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        if ($method == "POST") {
            if ($body != null) {
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $body);
            }
        } else if ($method == "DELETE") {
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "DELETE");
        } else if ($method == "PUT") {
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($handle, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code != 200) {
            Logger::ERROR("sendHTTP(): http error! httpCode=" . $code);
            return false;
        }
        return true;
    }
}