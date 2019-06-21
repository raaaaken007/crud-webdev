<?php 
//I love you beb 😗 
include_once '../includes/functions.inc.php';
header('Content-Type: application/json');
$tableFriendSearch = $_POST['tableFriendSearch']; 
session_start();
//Input Validation

$stmt = '';
if(empty($tableFriendSearch)){
	$stmt = $mysqli->prepare("SELECT 
		friends_id,
		friends_name, 
		friends_age
		FROM friends 
		");
}else{
	$tableFriendSearch = '%'.$_POST['tableFriendSearch'].'%'; 
	$stmt = $mysqli->prepare("SELECT 
		friends_id,
		friends_name, 
		friends_age
		FROM friends 
		WHERE friends_name LIKE ?");	
	$stmt->bind_param('s', $tableFriendSearch); 
}
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(
	$users_id, 
	$users_username,
	$users_password
);
$numrows = $stmt->num_rows;
$return_arr = array(); 	
if($numrows >= 1){
	while ($stmt->fetch()) {
		$return_arr[] = array(
			$users_id, 
			$users_username,
			$users_password
		);

	}

	echo json_encode($return_arr);
}