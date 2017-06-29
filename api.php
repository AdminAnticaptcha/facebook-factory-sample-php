<?php

class Api {
    
    private     $input;
    private     $rawInput;
    private     $secretKey;
    
    public function __construct() {
        $this->secretKey = trim(file_get_contents("secretkey.txt"));
        $this->parsePostInput();
        $this->authorizePlatform();
    }
    
    public function success() {
        $this->apiResponse(array("status" => "success"));
    }
    
    public function apiResponse($data, $errorCode = 0) {
        $response = array_merge(array(
            "errorId"   =>  $errorCode
        ), $data);
        
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($response);
    }
    
    public function getInput($variable) {
        if (!isset($this->input[$variable])) return false;
        else return $this->input[$variable];
    }
    
    
    public function getInputInt($variable, $default = 0) {
        $value  =   $this->getInput($variable);
        if (is_numeric($value)) return (int)$value;
        else return $default;
    }
    
    private function parsePostInput() {
        $this->rawInput =   file_get_contents("php://input");
        $this->input    =   json_decode($this->rawInput, true, 128);
    }
    
    public function authorizePlatform() {
        global $_SERVER;
        if (!isset($_SERVER["HTTP_SIGNATURE"])) {
            $this->apiResponse(array("message" => "signature not found"), 1);
            exit;
        }
        if (sha1( $this->rawInput . $this->secretKey ) != $_SERVER["HTTP_SIGNATURE"]) {
            $this->apiResponse(array("incorrect signature"), 1);
            exit;
        }
    }
    
}