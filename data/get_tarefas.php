<?php
// Conexão com o banco de dados
include("../connection/conn.php");

// Consulta para obter todas as tarefas
$query = "SELECT * FROM tarefas";
$result = mysqli_query($conn, $query);

// Constroi a lista de tarefas HTML
$taskList = '';
while ($row = mysqli_fetch_assoc($result)) {
	$taskId = $row['id'];
	$title = $row['titulo'];
	$description = $row['descricao'];
	$bdaytime_up = $row['date_time'];
	$status = $row['status'];

	$taskList .= '<li>';
	$taskList .= '<h3>' . $title . '</h3>';
	$taskList .= '<p>' . $description . '</p>';
	$taskList .= '<span class="task-status" data-task-id="' . $taskId . '" data-status="' . $status . '">Marcar como ' . ($status == 'Incomplete' ? 'Completa' : 'Incompleta') . '</span>';
	$taskList .= '<span class="task-delete" data-task-id="' . $taskId . '">Excluir</span>';
	$taskList .= '</li>';
}

echo $taskList;
?>
