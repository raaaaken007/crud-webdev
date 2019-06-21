<?php 
include_once 'includes/functions.inc.php';
session_start();
if(empty($_SESSION['loginSession'])){
	header('location: home.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<style type="text/css">
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
	}
</style>
<body>
	<h4>Welcome <?php echo $_SESSION['loginUsername']; ?>! <a href="includes/logout.inc.php">Logout</a></h4> 

	<p>Add Friends</p>
	<p><small id="addFriendsMsg"></small></p>
	<input type="text" id="addFriendsName" placeholder="Name">
	<input type="number" id="addFriendsAge" placeholder="Age">
	<input type="submit" id="addFriendsBtn" value="+ Add">
	<hr>
	<p>Friends List
		<input type="input" id="tableFriendSearch" value=""><input type="submit" id="tableFriendSearchBtn" value="Search"></p>
		<p><small id="tableFriendsMsg"></small></p>
		<table style="width:100%">
			<tr>
				<th>Full Name</th>
				<th>Age</th> 
				<th>Option</th>
			</tr>
			<tbody id="tableFriendsTbody"></tbody>
		</table>
		<hr>

		<div id="editDiv" hidden>
			<p>Edit Friends</p>
			<p><small id="editFriendsMsg"></small></p>
			<input type="text" id="editFriendsName" placeholder="Name">
			<input type="number" id="editFriendsAge" placeholder="Age">
			<input type="submit" id="editFriendsBtn" value="Save">
			<hr>
		</div>


		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script type="text/javascript">


			$('#addFriendsBtn').click(function(){
				var addFriendsName = $('#addFriendsName').val();
				var addFriendsAge = $('#addFriendsAge').val();
				$.post('includes/addFriends.inc.php',{addFriendsName,addFriendsAge},function(result){
					if(result.status == 'error'){
						$('#addFriendsMsg').html(result.msg)
					}else{
						$('#addFriendsMsg').html(result.msg)
						displayFriendList();
					}
				});
			});

			var globalResult
			var selectedFriendsId;
			function displayFriendList(){
				var tableFriendSearch = $('#tableFriendSearch').val();
				var tableFriendsTbodyHtml = '';
				$.post('json_data/friendList.php',{tableFriendSearch},function(result){
					globalResult = result
					for (var i = 0; i < result.length; i++) {
						tableFriendsTbodyHtml += '<tr>'+
						'<td>'+result[i][1]+'</td>'+
						'<td>'+result[i][2]+'</td> '+
						' <td><a href="#" onclick="editFriends('+i+')">Edit</a> | <a href="#" onclick="deleteFriends('+i+')">Delete</a></td>'+
						'</tr>';
					}
					$('#tableFriendsTbody').html(tableFriendsTbodyHtml)

				});
			}
			displayFriendList();


			$('#tableFriendSearchBtn').click(function(){
				displayFriendList();		
			})

			function editFriends(id){
				$('#editDiv').fadeIn();
				selectedFriendsId = globalResult[id][0];
				$('#editFriendsName').val(globalResult[id][1]);
				$('#editFriendsAge').val(globalResult[id][2]);
			}

			function deleteFriends(id){
				selectedFriendsId = globalResult[id][0];
				$.post('includes/deleteFriends.inc.php',{selectedFriendsId},function(result){
					if(result.status == 'error'){
						$('#tableFriendsMsg').html(result.msg) 
					}else{
						$('#tableFriendsMsg').html(result.msg)
						displayFriendList();
						setTimeout(function(){
							$('#editDiv').fadeOut();
						},1000)
					}
				});
			}

			$('#editFriendsBtn').click(function(){
				var editFriendsName = $('#editFriendsName').val();
				var editFriendsAge = $('#editFriendsAge').val();
				$.post('includes/editFriends.inc.php',{editFriendsName,editFriendsAge,selectedFriendsId},function(result){
					if(result.status == 'error'){
						$('#editFriendsMsg').html(result.msg) 
					}else{
						$('#editFriendsMsg').html(result.msg)
						displayFriendList();
						setTimeout(function(){
							$('#editDiv').fadeOut();
						},1000)
					}
				});
			});



		</script>

	</body>
	</html>