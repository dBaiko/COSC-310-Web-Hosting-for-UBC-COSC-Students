<?php

/**
 *  test case.
 */
use PHPUnit\Framework\TestCase;

require "../add.php";
require_once '../vendor/autoload.php';

class TestAdd extends TestCase 
{

    public function __construct() {
        parent::__construct();
        // Your construct here
    }
    
    public function testAdd(){
        $this->assertSame(6, add(3, 3));
    }
    
    
}

