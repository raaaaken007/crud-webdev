<?php 
//I love you beb :* 
include_once 'functions.inc.php';
header('Content-Type: application/json');
$loginUsername = $_POST['loginUsername']; 
$loginPassword = $_POST['loginPassword'];
session_start();
//Input Validation
if(empty($loginUsername)){
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Username Empty!'
		)
	);
	die();
}
if(empty($loginPassword)){
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Password Empty!'
		)
	);
	die();
}
//Get all matching username
$stmt = $mysqli->prepare("SELECT 
	users_id,
	users_username, 
	users_password
	FROM users 
	WHERE users_username = ?
	LIMIT 1");
$stmt->bind_param('s', $loginUsername); 
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(
	$users_id, 
	$users_username,
	$users_password
);
$stmt->fetch();
if ($stmt->num_rows == 1) {
	//Compare username and password if match
	if (password_verify($loginPassword, $users_password)) {
		echo json_encode(
			array(
				'status'=>'success',
				'msg'=>'Welcome!'
			)
		);
		$_SESSION['loginSession'] = $users_id;
		$_SESSION['loginUsername'] = $users_username;
		die();
	}else{
		echo json_encode(
			array(
				'status'=>'error',
				'msg'=>'Incorrect Password!'
			)
		);
		die();
	}
}else{
		echo json_encode(
			array(
				'status'=>'error',
				'msg'=>'No user found!'
			)
		);
		die();
}