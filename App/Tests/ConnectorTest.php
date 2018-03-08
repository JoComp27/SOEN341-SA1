<?php
//use PHPUnit\Framework\TestCase;
class ConnectorTest extends PHPUnit\Framework\TestCase
{
    public function test()
    {
        $user   = 'root';
        $password   = '';
        $database   = 'website_db';
        $link = new mysqli('localhost', $user, $password, $database) or die("Connection failed");
        $checker = False;
        if (mysqli_connect_errno()) {
            $check = False;
        }
        /* check if server is alive */
        if (mysqli_ping($link)) {
            $checker = True;
        } else {
            $checker = False;
        }
        /* close connection */
        mysqli_close($link);
        $this->AssertTrue($checker);
    }
}
?>