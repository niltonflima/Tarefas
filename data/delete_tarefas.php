<?php
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  	// Conectar ao banco de dados
	include("../connection/conn.php");
 	// Recebe os dados JSON
  	$json = file_get_contents('php://input');
  	$data = json_decode($json, true);
  	// Obt�m o ID do registro a ser exclu�do
  	$id = $data['id'];

  	// Excluir a tarefa do banco de dados
  	$sql = "DELETE FROM tarefas WHERE id=$id";
  	$conn->query($sql);

  	$conn->close();
}
?>
