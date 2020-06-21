<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WC_PayPhone_Exception extends Exception{
    // Redefine the exception so message isn't optional
    public function __construct($message, $statusCode, $error, $code = 0, Exception $previous = null) {
        // some code
    
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
        
        $this->status_code = $statusCode;
        $this->error = $error;
    }
    
    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    private $status_code;
    
    private $error;
    
    public function get_error(){
        return $this->error;
    }
    
    public function get_status(){
        return $this->status_code;
    }
    
}
