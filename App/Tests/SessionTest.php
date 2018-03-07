<?php
session_start();
//use PHPUnit\Framework\TestCase;

class SessionTest extends PHPUnit_Framework_TestCase{

    public function testTest1(){
    	
        $this->assertTrue(isset($_SESSION));


    }

}

?>