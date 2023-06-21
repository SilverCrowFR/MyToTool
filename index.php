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
		<a id='app_name' href="#">MyToTool</a>
		<a href="login.php" id='login_btn'>Se Connecter</a>
		<a href="register.php" id='signup_btn'>S'incrire</a>
		<a href="logout.php" id='logout_btn'>Deconnexion</a>
	</header>
</body>

</html>

<?php
include 'db.php';
session_start();
if(isset($_SESSION['user'])){		//logged in
	?>
	<script>
		document.querySelector('#login_btn').style.display = 'none';
		document.querySelector('#signup_btn').style.display = 'none';
		document.querySelector('#logout_btn').style.display = 'inline-block';
	</script>
	<div>
	 <?php echo '<h3 id="username">' . $_SESSION['user'] . '</h3>'; ?>
	</div>
	<form action="add_task.php" method='post' id='add_task_form'>
		<input type="text" name='description' placeholder='Ecrivez' id='description' required>
		<input type="submit" value='Ajouter une tache' id='add_task_submit'>
	</form>

	<?php
	$query = $con->prepare('select * from tasks, users where users.user_id = ? and tasks.user_id = users.user_id');
	// tasks.user_id = users.user_id seems unnecessary
	$query->execute(array($_SESSION['user_id']));
	$result = $query->fetchAll();
	foreach($result as $row) {
		?>
		<div class='task_container'>
			<div class='content'>
			<p id='task_p'> <?php echo $row['description'] ?> </p>
				<div class='button_task'>
				<a id='delete' href="index.php?del_task= <?php echo $row['task_id'] ?>">Supprimer</a>
				<a id='edit' href="index.php?edit_task= <?php echo $row['task_id'] ?>">Modifier</a>
				<input type="text" id='description'  placeholder='Description'>
				</div>
			</div>
		</div>
		<?php
	}
	
	// delete task
	if(isset($_GET['del_task'])) {
		$query = $con->prepare('delete from tasks where task_id = ?');
		$query->execute(array($_GET['del_task']));
		header('Location: index.php');
	}

	// edit task
	if(isset($_GET['edit_task'])) {
		$_SESSION['edit_task'] = $_GET['edit_task'];

		// to fill the input text field with description to be edited
		$query = $con->prepare('select description from tasks where task_id = ?');
		$query->execute(array($_SESSION['edit_task']));
		$row = $query->fetch(PDO::FETCH_ASSOC);
		$_SESSION['description'] = $row['description'];
		header('Location: edit_task.php');

	}

}
else {		//logged out
	?>
	<script>
		document.querySelector('#login_btn').style.display = 'inline-block';
		document.querySelector('#signup_btn').style.display = 'inline-block';
		document.querySelector('#logout_btn').style.display = 'none';
	</script>
	<?php
}