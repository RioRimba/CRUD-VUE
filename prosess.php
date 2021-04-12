<?php
	header("Access-Control-Allow-Origin: *");
	$conn = new mysqli("localhost","root","","crud_vue");
	if($conn->connect_error){
		die("gagal terhubung".$conn->connect_error);
	}

	$result = array('error'=>false);
	$action = '';

	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}

	if ($action == 'read') {
		$sql = $conn->query("SELECT * FROM user");
		$user = array();
		while($row = $sql->fetch_assoc()){
			array_push($user, $row);
		}
		$result['user'] = $user;
	}

	if ($action == 'create') {
		$name 	= $_POST['name'];
		$email 	= $_POST['email'];
		$phone 	= $_POST['phone'];

		$sql = $conn->query("INSERT INTO user (name,email,phone) VALUES ('$name','$email','$phone')");
		if ($sql) {
			$result['message'] = "User berhasil ditambah";
		}else{
			$result['error'] = true;
			$result['message'] = "User gagal ditambah";
		}
	}

	if ($action == 'update') {
		$id		= $_POST['id'];
		$name 	= $_POST['name'];
		$email 	= $_POST['email'];
		$phone 	= $_POST['phone'];

		$sql = $conn->query("UPDATE user SET name='$name', email='$email', phone='$phone' WHERE id='$id'");
		if ($sql) {
			$result['message'] = "User berhasil diupdate";
		}else{
			$result['error'] = true;
			$result['message'] = "User gagal diupdate";
		}
	}

	if ($action == 'delete') {
		$id		= $_POST['id'];

		$sql = $conn->query("DELETE FROM user WHERE id='$id'");
		if ($sql) {
			$result['message'] = "User berhasil dihapus";
		}else{
			$result['error'] = true;
			$result['message'] = "User gagal dihapus";
		}
	}

	$conn->close();
	echo json_encode($result);
?>
