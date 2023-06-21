<?php
include 'db.php';
session_start();
$_POST = array_map('trim', $_POST);
if(empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
	$_SESSION['error'] = 'Veuillez remplir tout les champs.';
	header('Location: register.php');
}
if(strlen($_POST['password']) < 6) {
	$_SESSION['error'] = 'Le mot de passe doit être au moins de 6 caractères';
	header('Location: register.php');
}
else if($_POST['password'] == $_POST['confirm_password']) {
	$stmt = $con->prepare('SELECT count(*) from users where username = ?');
	$stmt->execute(array($_POST['username']));
	if($stmt->fetchColumn()) {
		$_SESSION['error'] = 'Ce nom existe déjà.';
		header('Location: register.php');
	}
	else {
		$stmt = $con->prepare('INSERT into users (username, email, password) VALUES (?,?,?)');
		if($stmt->execute(array($_POST['username'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)))) {
			$_SESSION['success'] = 'Compte créer.';
			header('Location: register.php');
		}
		else {
			$_SESSION['error'] = 'Un problème est survenu lors de la création de votre compte.';
			header('Location: register.php');
		}
	}
}
else {
	$_SESSION['error'] = 'Le mots de passe ne correspond pas.';
	header('Location: register.php');
}