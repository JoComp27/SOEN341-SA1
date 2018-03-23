<?php
//use PHPUnit\Framework\TestCase;

class SessionTest extends PHPUnit\Framework\TestCase{

    public function testTest1(){
    	
        $this->assertTrue(isset($_SESSION));
    }

}

?>
