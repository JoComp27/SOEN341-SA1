<html>
<head>
<title>Add Student</title>
</head>
<body>
<?php
 
if(isset($_POST['submit'])){
    
    $data_missing = array();
    
    if(empty($_POST['first_name'])){
 
        // Adds name to array
        $data_missing[] = 'First Name';
 
    } else {
 
        // Trim white space from the name and store the name
        $f_name = trim($_POST['first_name']);
 
    }
 
    if(empty($_POST['last_name'])){
 
        // Adds name to array
        $data_missing[] = 'Last Name';
 
    } else{
 
        // Trim white space from the name and store the name
        $l_name = trim($_POST['last_name']);
 
    }
    
    if(empty($data_missing)){
        
        require_once('C:/xampp/htdocs/mysqli_connect.php');
        
        $query = "INSERT INTO students (first_name, last_name) VALUES (?, ?)";
        
        $stmt = mysqli_prepare($dbc, $query);
        
        mysqli_stmt_bind_param($stmt, "ss", $f_name, $l_name);
        
        mysqli_stmt_execute($stmt);
        
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        
        if($affected_rows == 1){
            
            echo 'Student Entered';
            
            mysqli_stmt_close($stmt);
            
            mysqli_close($dbc);
            
        } else {
            
            echo 'Error Occurred<br />';
            echo mysqli_error();
            
            mysqli_stmt_close($stmt);
            
            mysqli_close($dbc);
            
        }
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}
 
?>
 
<form action="http://localhost:1234/studentadded.php" method="post">
    
    <b>Add a New Student</b>
    
    <p>First Name:
<input type="text" name="first_name" size="30" value="" />
</p>
 
<p>Last Name:
<input type="text" name="last_name" size="30" value="" />
</p>
 
<p>
    <input type="submit" name="submit" value="Send" />
</p>
    
</form>
</body>
</html>