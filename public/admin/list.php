<?php
session_start();
#$_SESSION['messages'][] = 'TEST MESSAGE1';
#$_SESSION['messages'][] = 'TEST MESSAGE2';

$hostname = "localhost";
$username = "root";
$password = "root";
$databasename = "bigband";

$conn = new mysqli($hostname, $username, $password, $databasename);
if($conn->connect_error){
	die("Connection to DB failed: " . $conn->connect_error);
}
#print_r($_SESSION);
?>
<?php include('../header.php') ?>
<table>
<tr>
	<td>ID</td>
	<td>Slug</td>
	<td>Url</td>
	<td>Timestamp</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<?php

$sql = "SELECT `id`, `slug`, `url`, `timestamp` FROM `url_shortener`";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	print('	<tr>
				<td>' . $row['id'] . '</td>
				<td>' . $row['slug'] . '</td>
				<td>' . $row['url'] . '</td>
				<td>' . $row['timestamp'] . '</td>
				<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>
				<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>
			</tr>');
}

?>
</table>