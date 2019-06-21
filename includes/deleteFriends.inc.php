<?php 
include_once 'functions.inc.php';
header('Content-Type: application/json');
$selectedFriendsId = $_POST['selectedFriendsId'];
session_start();


$stmt = $mysqli->prepare("DELETE FROM `friends` WHERE `friends_id`=?
	");
$stmt->bind_param('s',$selectedFriendsId); 
if($stmt->execute()){
	echo json_encode(
		array(
			'status'=>'success',
			'msg'=>'Friends Deleted!'
		)
	);
	die();
}else{
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Delete Failed!'
		)
	);
	die();
}