<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	// Conectar ao banco de dados
	include("../connection/conn.php");

  	$id = $_POST['id'];

	//Para atualização somente do status
	if (isset($_POST['sts'])){
  		$sql = "UPDATE tarefas SET sts='".$_POST['sts']."', date_end='".$_POST['date_end']."' WHERE id=$id";
  		$conn->query($sql);
		echo json_encode($response);
		exit();
	}

  	$title = mysqli_real_escape_string($conn,$_POST['title']);
  	$description = mysqli_real_escape_string($conn,$_POST['description']);
	$date_time = $_POST['bdaytime'];

  	// Atualizar a tarefa no banco de dados
  	$sql = "UPDATE tarefas SET title='$title', description='$description', date_time='$date_time' WHERE id=$id";
  	$conn->query($sql);

  	// Obter a data de atualização
  	$updatedAt = date('Y-m-d H:i:s');

  	// Obter os detalhes atualizados da tarefa
  	$sql = "SELECT * FROM tasks WHERE id=$id";
  	$result = $conn->query($sql);
  	$task = $result->fetch_assoc();

  	$conn->close();

  	$response = [
    	'updatedAt' => $updatedAt,
    	'task' => $task
  	];

  	echo json_encode($response);
}
?>