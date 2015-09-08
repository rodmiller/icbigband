<?php
# Note, SQL to create DB 

/*
CREATE TABLE `url_shortener` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`slug` VARCHAR(255) NOT NULL DEFAULT '0',
	`url` VARCHAR(255) NOT NULL DEFAULT '0',
	`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `slug` (`slug`)
)
ENGINE=InnoDB;
*/


#NB Before deploy adjust print -> header

session_start();

$hostname = "localhost";
$username = "root";
$password = "root";
#$databasename = "bigband";

$conn = new mysqli($hostname, $username, $password);
if($conn->connect_error){
	die("Connection to DB failed: " . $conn->connect_error);
}

#Do database intro stuff
#Make the DB if it doesn't exist
$sql = 'CREATE DATABASE IF NOT EXISTS `bigband`';
$conn->query($sql);

$hostname = "localhost";
$username = "root";
$password = "root";
$databasename = "bigband";

$conn = new mysqli($hostname, $username, $password, $databasename);
if($conn->connect_error){
	die("Connection to DB failed: " . $conn->connect_error);
}

$sql = 'SELECT 1 FROM `url_shortener` LIMIT 1';
$result = $conn->query($sql);
if(!$result){
	#It doesn't exist
	#Next make the table if that doesn't exist
	$sql = "CREATE TABLE `url_shortener` (
		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`slug` VARCHAR(255) NOT NULL DEFAULT '0',
		`url` VARCHAR(255) NOT NULL DEFAULT '0',
		`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`),
		UNIQUE INDEX `slug` (`slug`)
	)
	ENGINE=InnoDB;";
	$result = $conn->query($sql);
}

$sql = "SELECT `id` FROM `url_shortener` WHERE `slug`='default';";
$result = $conn->query($sql);
if($result->num_rows == 0){
	#Nothing in the default
	$sql = "INSERT INTO `url_shortener` (`url`, `slug`) VALUES ('http://icbigband.com', 'default');";
	$conn->query($sql);
}

if($_GET){
	if($_GET['slug']){
		#print($_GET['slug']);
		$sql = "SELECT `url` FROM `url_shortener` WHERE `slug`='" . $_GET['slug'] . "';";
		$result = $conn->query($sql);
		#print('<br />');
		if($result->num_rows == 1){
			$row = $result->fetch_assoc();
			#print_r($row['url']);
			#header('Location: ' . $row['url']) ;
			print('Location: ' . $row['url']);
		}
	}
}
#No results for the slug. Return the root url
$sql  = "SELECT `url` FROM `url_shortener` WHERE `slug`='default';";
$result = $conn->query($sql);
if($result->num_rows == 1){
	$row = $result->fetch_assoc();
	print('Location: ' . $row['url']);
}else{
	#No default set.
	print('No default site set in database. Please set one before use by setting the slug to "default" <a href="admin/add.php">here</a>');
}

?>