<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<?php include ('sql_connector.php');?>

<!DOCTYPE html>

<html>
	<head>
		<style> 
			body{margin-left: 100px; margin-right: 100px; background-color: white; width: 1100px; margin-top:100px}
			.c1{length: 700px; margin-left: 100px; margin-right : 100px; background-color: lightgrey; margin-top: 50px; margin-bottom: 50px}
			#profilepic {border-radius : 50%; position: relative; float: right; margin-right: 50px;}
			#aboutme{border: 10px groove yellowgreen;  padding: 10px; border-collapse: separate; width: 300px; margin-left: 50px; margin-top: 20px; }
			.t2{margin-left: 200px; margin-top: 10px; align: center; border-collapse: separate; border-radius: 25px; border: 2px solid #73AD21; padding: 20px; }
			.tab {width:80%; overflow: hidden; border: 1px solid #ccc; margin-left: 50px; margin-top: 20px; background-color: #FF8C00; border-radius: 25px}
			.tab button {background-color: inherit; float: left; border: none; outline: none; cursor: pointer; padding: 14px 16px; transition: 0.3s; font-size: 36px;}
			.tab button:hover {background-color: #000;}
			.tab button.active {background-color: #4CAF50 !important;}
			.tabcontent {display: none; padding: 6px 12px; border: 1px solid #ccc; border-top: none;}
		</style>
		
		<link href="ask_question.css" type="text/css" rel="stylesheet">
		<?php include "header.php" ?>
		<link rel="stylesheet" type="text/css" href="home.css">
		
	</head>
	
	<body>
		    
        <div class="c1">
             <h1 class="">Welcome to <?php echo $_SESSION['user_name'] ?>'s profile page!</h1>
			 <div ><a href="" class=""><img id="profilepic" title="profile image" class="" src="https://freeiconshop.com/wp-content/uploads/edd/person-flat.png"></a></div>
         
          <button type="button" class="btn btn-success">Follow me!</button>  <button type="button" class="btn btn-info">Send me a message</button>
		</br></br>
		
		<table class="aboutme">
			<tr>
				<th>About Me!</th>
				<th> </th>
			</tr>
			<tr>
				<td>Gender: </td>
				<td> <?php  $select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
			$sql = mysqli_query($db, $select_query);
			$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_gender']; ?></td>
			</tr>
			<tr>
				<td>Birthday: </td>
				<td><?php  $select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
			$sql = mysqli_query($db, $select_query);
			$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_birthDate']; ?></td>
			</tr>
			<tr>
				<td>Member since: </td>
				<td> <?php  $select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
			$sql = mysqli_query($db, $select_query);
			$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_date']; ?></td>
			</tr>
		</table></br>
		
		<!--Reference: https://www.w3schools.com/howto/howto_css_icon_bar.asp -->
		<div class="tab">
			<button class="tablinks" onclick="openTab(event, 'about')"><a class="active" href="#"><i class="fa fa-address-card"></i></a> </button>
			<button class="tablinks" onclick="openTab(event, 'mail')"><a href="#"><i class="fa fa-envelope"></i></a> </button>
			<button class="tablinks" onclick="openTab(event, 'activity')"><a href="#"><i class="fa fa-line-chart"></i></a></button>
			<button class="tablinks" onclick="openTab(event, 'edit')"><a href="#"><i class="fa fa-edit"></i></a> </button>
		</div>
		
		<div id="activity" class="tabcontent">
			<table class="t2">
				<tr>
					<th><h3>Activity</h3> </th>
				</tr>
				<tr>
					<td> 
					<ul class="">
						<li class=""><strong class="">Questions asked: <?php  $select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
							$sql = mysqli_query($db, $select_query);
							$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_questions_count']; ?></strong></li>
						<li class=""><strong class="">Answers: <?php  $select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
							$sql = mysqli_query($db, $select_query);
							$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_answers_count']; ?></strong></li>
						<li class=""><strong class="">Likes</strong></li>
						<li class=""><strong class="">Followers</strong></li>
            </ul>
					</td>
				</tr>
			</table>
		</div>

		<div id="mail" class="tabcontent">
			<table class="t2">
				<tr>
					<th><h3> E-mail</h3> </th>
				</tr>
				<tr>
					<td> 
					<?php  
						$select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
						$sql = mysqli_query($db, $select_query);
						$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_email']; 
					?>
					</td>
				</tr>
			</table>
		</div>

		<div id="about" class="tabcontent">
				<table class="t2">
				<tr>
					<th><h3> User's bio: </h3></th>
				</tr>
				<tr>
					<td> 
					<?php  
						$select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
						$sql = mysqli_query($db, $select_query);
						$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_profile_description_long']; 
					?>
					</td>
				</tr>
			</table>
		</div>

		<div id="edit" class="tabcontent">
			<table class="t2">
				<tr>
					<th><h3> Edit profile </h3></th>
				</tr>
				<tr>
					<td> 
					<?php  
						$select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
						$sql = mysqli_query($db, $select_query);
						$get_users = mysqli_fetch_assoc($sql); echo  $get_users['user_profile_description_long']; 
					?>
					</td>
				</tr>
			</table>
		</div>
		
	<script>
	// Reference: https://www.w3schools.com/howto/howto_js_tabs.asp
		function openTab(evt, cityName) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
}
	</script>
			
		</br>
            
        </div>
      
	</body>
</html>

