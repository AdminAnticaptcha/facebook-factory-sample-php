<?php

class Api {
    
    private  $input;
    
    public function __construct() {
        $this->parsePostInput();
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
        if (is_numeric($value)) return $value;
        else return $default;
    }
    
    private function parsePostInput() {
        $rawInput       =   file_get_contents("php://input");
        $this->input    =   json_decode($rawInput, true, 128);
    }
    
}