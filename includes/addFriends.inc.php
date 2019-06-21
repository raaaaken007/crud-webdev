<?php 
include_once 'functions.inc.php';
header('Content-Type: application/json');
$addFriendsName = $_POST['addFriendsName'];
$addFriendsAge = $_POST['addFriendsAge'];
//Input Validation
if(empty($addFriendsName)){
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Friends Name Empty!'
		)
	);
	die();
}
if(empty($addFriendsAge)){
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Friends Age Empty!'
		)
	);
	die();
}
if(!is_numeric($addFriendsAge)){
	echo json_encode(
		array(
			'status'=>'error',
			'msg'=>'Friends Age must be numeric!'
		)
	);
	die();
}
//Add friends query
$friends_id = generateRandomString();
$stmt = $mysqli->prepare("INSERT INTO `friends`(
	`friends_id`, 
	`friends_name`, 
	`friends_age`
) VALUES (?,?,?)"
);
$stmt->bind_param('sss',$friends_id,$addFriendsName,$addFriendsAge); 

if($stmt->execute()){
	echo json_encode(
		array(
			'status'=>'success',
			'msg'=>$addFriendsName.' Added!'
		)
	);
	die();
}
