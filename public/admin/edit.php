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

if($_POST){
	#We have been posted stuff
	if($_POST['url'] and $_POST['id']){
		#We have been posted a url. Yay
		if($_POST['slug']){
			#We have been posted a slug too so just pop these into the db
			$sql = "UPDATE `url_shortener` SET 	`url`='" . $_POST['url'] . "', `slug`='" . $_POST['slug'] . "' WHERE `id`=" . $_POST['id'] . ";";
			$result = $conn->query($sql);
		}else{
			#No slug so generate one.
			$slug = substr(md5(microtime()),rand(0,26),5);
			while(!checkSlug($conn, $slug)){
				#While there is a duplicate slug in the db, go and generate a new one.
				$slug = substr(md5(microtime()),rand(0,26),5);
			}
			#Now we have a unique slug
			$sql = "UPDATE `url_shortener` SET `url`='" . $_POST['url'] . "', `slug`='" . $slug . "' WHERE `id`=" . $_POST['id'] . ";";
			$result = $conn->query($sql);
			$_SESSION['message'] = 'Successfully added.';

		}
		header("Location: list.php");
	}
}


if(!$_GET){
	#No get variable passed
	header('Location: list.php');
};
if(!$_GET['id']){
	#No id passed in get.
	$_SESSION['messages'][] = 'No id to edit.';
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
$row = $result->fetch_assoc();



?>
<?php include('../header.php') ?>
<form name='editForm' method='post' >
<input name='id' type='hidden' value='<?php print($row['id']); ?>' />
<p><input name='slug' type='text' value='<?php print($row['slug']); ?>' placeholder='Leave blank for random' /></p>
<p><input name='url' type='text' value='<?php print($row['url']); ?>' /></p>
<p><input name='Submit' value='Submit' type='submit' /></p>
</form>