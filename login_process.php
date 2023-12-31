<?php
include 'db.php';
session_start();
$_POST = array_map('trim', $_POST);
if(!empty($_POST['username']) && !empty($_POST['password'])) {
	$stmt = $con->prepare('SELECT * from users where username = ?');
	$stmt->execute(array($_POST['username']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row)
		if(password_verify($_POST['password'], $row['password'])) {
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['user'] = 'Bienvenue, ' . $row['username'] . ' !';		//logged in
			header('Location: index.php');
		}
		else {
			$_SESSION['error'] = 'Mot de passe incorrect.';
			header('Location: login.php');
		}
	else {
		$_SESSION['error'] = "Ce nom d'utilisateur n'existe pas.";
		header('Location: login.php');
	}
}
else {
	$_SESSION['error'] = "Veuillez remplir les deux champs.";
	header('Location: login.php');
}