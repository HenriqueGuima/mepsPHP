<?php
 	session_start();
 	include("config.php");

 	$msg = "";
 	if (isset($_POST['username']) && !empty($_POST['username'])) {
	  	$username = $_POST['username'];
	} else {
	  	$msg .= "O username não se encontra definido ou não foi preenchido!<br>";
	}
	if (isset($_POST['password']) && !empty($_POST['password'])) {
	  	$password = sha1($_POST['password']);
	} else {
	  	$msg .= "A Password não se encontra definida ou não foi preenchida!<br>";
	}

	if (strlen($msg)>0) {
	  	header("Location: ../login.php?er=1");
	} else {
		$result = $pdo->prepare("SELECT * FROM backoffice WHERE username = :username AND password = :password");
		$result->execute(array('username' => $username, 'password' => $password));
		$num_rows = $result->rowCount();
		$row = $result->fetch();
		if ($row['password']!=$password || $row['username']!=$username) {
			session_destroy();
			header("Location: ../login.php?er=2");
		} else {
			$_SESSION['admin'] = $username;
			header("Location: ../index.php");
		}
	}
?>