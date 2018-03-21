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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<script>
			function userSub(subscriber_ID, subscribee_ID){
				<?php 
					
				?>
			}
		</script>
		
	</head>
	
	<body>
		
		<?php 
			if (isset($_GET['id'])) {
				$usr_id = $_GET['id'];
				$select_query = "select * from users WHERE user_id='".$usr_id."'";
				$sql = mysqli_query($db, $select_query);
				$get_users = mysqli_fetch_assoc($sql);
				$name = $get_users['user_name'];
				$gender = $get_users['user_gender'];
				$bday = $get_users['user_birthDate'];
				$membSince = $get_users['user_date'];
				$nbrQsts = $get_users['user_questions_count'];
				$nbrAns = $get_users['user_answers_count']; 
				$subscribers = $get_users['user_followers_count'];
				$email = $get_users['user_email'];
				$lBio = $get_users['user_profile_description_long']; 
				$sBio = $get_users['user_profile_description_short'];
			} else {
				$select_query = "select * from users WHERE user_name='".$_SESSION['user_name']."'";
				$sql = mysqli_query($db, $select_query);
				$get_users = mysqli_fetch_assoc($sql);
				$name = $_SESSION['user_name'];
				$gender = $get_users['user_gender'];
				$bday = $get_users['user_birthDate'];
				$membSince = $get_users['user_date'];
				$nbrQsts = $get_users['user_questions_count'];
				$nbrAns = $get_users['user_answers_count']; 
				$subscribers = $get_users['user_followers_count'] ;
				$email = $get_users['user_email'];
				$lBio = $get_users['user_profile_description_long']; 
				$sBio = $get_users['user_profile_description_short'];
			}
			
		?>		
        <div class="c1">
             <h1 class="">Welcome to <?php echo $name ?>'s profile page!</h1>
			 <div ><a href="" class=""><img id="profilepic" title="profile image" class="" src="https://freeiconshop.com/wp-content/uploads/edd/person-flat.png"></a></div>
         
          <button type="button" class="btn btn-success" onclick="" >Subscribe to me!</button>  <button type="button" class="btn btn-info">Send me a message</button>
		</br></br>
		
		<table class="aboutme">
			<tr>
				<th>About Me!</th>
				<th> <?php echo $sBio ?></th>
			</tr>
			<tr>
				<td>Gender: </td>
				<td> <?php  echo $gender ?></td>
			</tr>
			<tr>
				<td>Birthday: </td>
				<td><?php  echo $bday ?></td>
			</tr>
			<tr>
				<td>Member since: </td>
				<td> <?php  echo $membSince ?></td>
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
						<li class=""><strong class="">Questions asked: <?php echo $nbrQsts ?></strong></li>
						<li class=""><strong class="">Answers: <?php echo $nbrAns  ?></strong></li>
						<li class=""><strong class="">Subscribers: <?php echo $subscribers ?></strong></li>
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
					<?php  echo $email	?>
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
					<?php echo $lBio ?>
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
					</td>
				</tr>
			</table>
		</div>
		
	<script>
	// Reference: https://www.w3schools.com/howto/howto_js_tabs.asp
		function openTab(evt, obj) {
		var i, tabcontent, tablinks;
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(obj).style.display = "block";
		evt.currentTarget.className += " active";
}
	</script>
			
		</br>
            
        </div>
      
	</body>
</html>

