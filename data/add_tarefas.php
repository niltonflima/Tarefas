<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Conectar ao banco de dados
	include("../connection/conn.php");
  
  	$title = mysqli_real_escape_string($conn,$_POST['title']);
  	$description = mysqli_real_escape_string($conn,$_POST['description']);
	$date_time = $_POST['bdaytime'];
	
  	// Inserir a nova tarefa no banco de dados
  	$sql = "INSERT INTO tarefas (title, description, date_time, sts) VALUES ('$title', '$description','$date_time','a')";
  	$conn->query($sql);

  	$conn->close();
}
?>
