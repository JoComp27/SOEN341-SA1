<?php
//use PHPUnit\Framework\TestCase;

class LogoutTest extends PHPUnit\Framework\TestCase{

    public function testTest1(){
    	if (!isset($_SESSION)){
			$this->assertFalse(False);
			$_SESSION = array('auth' => 'True', 'user_name' => 'Test', 'user_id' => '1');
			
		}
		include(dirname(__FILE__)."/../PHP_HTML/login sample/signOut_Submission.php");
		//$this->assertRedirectTo('../PHP_HTML/home');
		
		if (isset($_SESSION)){
			$this->assertTrue(False);
		}
		else{
			$this->assertTrue(True);
		}
    }

}

?>
