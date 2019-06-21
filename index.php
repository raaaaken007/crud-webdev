<?php 
include_once 'includes/functions.inc.php';
session_start();
if(!empty($_SESSION['loginSession'])){
	header('location: home.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Basic Crud With Login</title>
</head>
<body>
	<h4>Login</h4>

	<p><small id="loginMsg"></small></p>
	<input type="text" id="loginUsername" placeholder="Username">
	<input type="password" id="loginPassword" placeholder="Password">
	<input type="submit" id="loginBtn" value="Login">

	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script type="text/javascript">

		//Once na click ung login button mag rurun ung functions sa baba 
		$('#loginBtn').click(function(){
			var loginUsername = $('#loginUsername').val();
			var loginPassword = $('#loginPassword').val();
			$.post('includes/login.inc.php',{loginUsername,loginPassword},function(result){

				if(result.status == 'error'){ //If error. mag shshow ung error message.
					$('#loginMsg').html(result.msg) //I didisplay ung error sa <small id="loginMsg"></small>
				}else{
					$('#loginMsg').html(result.msg)
					setTimeout(function(){
						window.location.reload()
					},500)
				}

			});
		});

	</script>
</body>
</html>