<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "root";
$databasename = "bigband";

$conn = new mysqli($hostname, $username, $password, $databasename);
if($conn->connect_error){
	die("Connection to DB failed: " . $conn->connect_error);
}

function checkSlug($conn, $slug){
	$sql = "SELECT `id` FROM `url_shortener` WHERE `slug` = '" . $slug . "';";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
		#There is a duplicate slug in the db
		return False;
	}else{
		#Its unique
		return True;
	}
}

if(!$_GET){
	#No get variable passed
	header('Location: list.php');
};
if(!$_GET['id']){
	#No id passed in get.
	$_SESSION['messages'][] = 'No id to delete.';
	header('Location: list.php');
};
$sql = "SELECT `id`, `slug`, `url` FROM `url_shortener` WHERE `id` = '" . $_GET['id'] . "';";
$result = $conn->query($sql);
if($result->num_rows == 0){
	#Nothing returned
	$_SESSION['messages'][] = 'No entry found for this id.';
	header('Location: list.php');
}elseif($result->num_rows > 1){
	#More than one returned. We should NOT be here. I'm scared.
	header('Location: list.php');
}
# One thing returned. Good.
$sql = "DELETE FROM `url_shortener` WHERE `id`='" . $_GET['id'] . "';";
$conn->query($sql);
header('Location: list.php');



?>