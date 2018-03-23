<?php
session_start();
//use PHPUnit\Framework\TestCase;

class LogoutTest extends PHPUnit\Framework\TestCase{

    public function testTest1(){
    	if (!isset($_SESSION)){
			$this->assertFalse(False);
			session_start();
			$_SESSION = array('auth' => 'True', 'user_name' => 'Test', 'user_id' => '1');
			
		}
		require('../PHP_HTML/login sample/signOut_Submission');
		$this->assertRedirectTo('../PHP_HTML/home');
		
		if (!isset($_SESSION)){
        $this->assertTrue(True);
		}
    }

}

?>
