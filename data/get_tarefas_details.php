<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  	$id = $_POST['id'];

	// Conectar ao banco de dados
	include("../connection/conn.php");

  	$sql = "SELECT * FROM tarefas WHERE id=$id";
  	$result = $conn->query($sql);

  	if ($result->num_rows > 0) {
    	$row = $result->fetch_assoc();
    	echo json_encode($row);
  	} else {
    	echo json_encode(null);
  	}
  $conn->close();
}
?>
