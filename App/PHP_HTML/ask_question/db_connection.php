<?php
function OpenCon() {
    $conn = new mysqli("localhost","root","1308","okapi_db") or die("Connect failed: %s\n". $conn -> error);
    return $conn;
}

function CloseCon($conn) {
    $conn -> close();
}

?>