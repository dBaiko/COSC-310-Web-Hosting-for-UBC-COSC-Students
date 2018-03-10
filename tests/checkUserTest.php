<?php

use PHPUnit\Framework\TestCase;



require_once __DIR__ . '/../php/checkUser.php';
//require '../vendor/autoload.php';

class checkUserTest extends TestCase
{
   
    public function __construct() {
        parent::__construct();
        // Your construct here
    }
     
    public function testCheckUserExisits(){
        $check = new userNameChecker();
        $this->assertEquals("1", $check->checkUser("dillyjb"));
        //$this->assertTrue(true);
    }
    
    
    
  
}