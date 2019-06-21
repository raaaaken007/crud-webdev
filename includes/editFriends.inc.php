<?php 
include_once 'functions.inc.php';
header('Content-Type: application/json');
$editFriendsName = $_POST['editFriendsName']; 
$editFriendsAge = $_POST['editFriendsAge'];
$selectedFriendsId = $_POST['selectedFriendsId'];
session_start();
//Input Validation
if(empty($editFriendsName)){
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Friends Name Empty!'
		)
	);
	die();
}
if(empty($editFriendsAge)){
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Friends Age Empty!'
		)
	);
	die();
}

$stmt = $mysqli->prepare("UPDATE `friends` SET 
	`friends_name`=?,
	`friends_age`=? 
	WHERE `friends_id`=?
	");
$stmt->bind_param('sss', $editFriendsName, $editFriendsAge, $selectedFriendsId); 

if($stmt->execute()){
	echo json_encode(
		array(
			'status'=>'success',
			'msg'=>'Friends Updated!'
		)
	);
	die();
}else{
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Update Failed!'
		)
	);
	die();
}