<a href='/admin/add.php'>Add</a> ---------- <a href='/admin/list.php'>List</a>
<?php
#print_r($_SESSION);
if(isset($_SESSION['messages'])){
	foreach($_SESSION['messages'] as $key => $message){
		print('<p>' . $message . '</p>');
		unset($_SESSION['messages'][$key]);
	}
}
?>