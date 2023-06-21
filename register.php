<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>MyToTool</title>
	<link rel="stylesheet" href="./style/style.css">
</head>
<body>
	<header><a href="index.php" id='app_name' class="header">To-do List</a></header>
	<form action="register_process.php" method="post">
		<input type="text" placeholder="Nom" name='username' required pattern="\S+" title="Les espaces ne sont pas autorisés.">
		<input type="email" placeholder="E-mail" name='email' required>
		<input type="password" placeholder="Mot de Passe" name='password' required pattern="\S+" title="Les espaces ne sont pas autorisés." minlength=6>
		<input type="password" placeholder="Confirmer votre mot de passe" name='confirm_password' required>
		<input type="submit" value="S'inscrire">
	</form>
</body>
</html>

<?php
session_start();
if(isset($_SESSION['error']))
		echo "<p class='error'>" . $_SESSION['error'] . '</p>';
unset($_SESSION['error']);

if(isset($_SESSION['success']))
		echo "<p class='success'>" . $_SESSION['success'] . '</p>';
unset($_SESSION['success']);

if(isset($_SESSION['user']))
	header('Location: index.php');
?>	