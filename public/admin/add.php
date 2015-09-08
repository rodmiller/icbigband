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
	#We have been posted data
	$error = False;
	if(!$_POST['slug']){
		# We haven't been sent a slug so generate one
		$slug = substr(md5(microtime()),rand(0,26),5);
		# Check whether the slug is already in the db
		while(!checkSlug($conn, $slug)){
			# Lets loop until we get a unique one
			$slug = substr(md5(microtime()),rand(0,26),5);
			#$sql = "SELECT `id` FROM `url_shortener` WHERE `slug` = '" . $slug . "';";
			#$result = $conn->query($sql);
		}
	}else{
		# We have been sent a slug so save it into the $slug variable
		$slug = $_POST['slug'];
		if(!checkSlug($conn, $slug)){
			#Its a duplicate slug.
			print('Duplicate slug listed in database. Please remove it or try again.');
			$error = True;
		}
	}	
	#Now we have a unique slug so we can add the info to the db
	if(!$error){
		$sql = "INSERT INTO `url_shortener` (`slug`, `url`) VALUES ('" . $slug . "', '" . $_POST['url'] . "')";
		$result = $conn->query($sql);
		#print('Added redirect: ' . $slug . ' -> ' . $_POST['url'] );
		$_SESSION['messages'][] = 'Added redirect: ' . $slug . ' -> ' . $_POST['url'];
		header('Location: list.php');
	}
}


?>
<?php include('../header.php') ?>
<form name='add_form' method='POST' >
<p>Slug: <input name='slug' placeholder='(Leave blank for random)' type='text' /></p>
<p>URL: <input name='url' placeholder='http://google.com' type='text' /></p>
<p><input name='submit' value='Add' type='submit' /></p>
</form>
