<?php
session_start();
?>

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
<header>
		<a id='app_name' href="#">To-do List</a>
		<a href="logout.php" id='logout_btn'>Deconnexion</a>
	</header>
	<form action="edit_task_process.php" method='post'>
	<h3>Editer Tache</h3>
		<input type="text" value='<?php echo $_SESSION["description"] ?>' name='description' required>
		<input type="submit" value='Sauvegarder'>
		<button id='cancel_btn'><a href="edit_task.php?cancel=1">Annuler</a></button>
	</form>
</body>
</html>


<?php
if(!isset(($_SESSION['edit_task'])))
	header('Location: index.php');

if(($_GET['cancel'])==1) {
	unset($_SESSION['edit_task']);
	header('Location: index.php');	
}
?>