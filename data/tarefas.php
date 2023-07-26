<?php
include("../connection/conn.php");

// Manipular requisições GET, POST e DELETE
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Obter todas as tarefas
  $sql = "SELECT * FROM tarefas ORDER BY created_at DESC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<li>';
      echo '<h3 class="task-title">' . $row['titulo'] . '</h3>';
      echo '<p class="task-description">' . $row['descricao'] . '</p>';
      echo '<button class="edit-task" data-id="' . $row['id'] . '">Editar</button>';
      echo '<button class="delete-task" data-id="' . $row['id'] . '">Excluir</button>';
      echo '</li>';
    }
  } else {
    echo '<li>Nenhuma tarefa encontrada.</li>';
  }  
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Adicionar nova tarefa
  $title = $_POST['titulo'];
  $description = $_POST['descricao'];

  $sql = "INSERT INTO tarefas (titulo, descricao) VALUES ('$title', '$description')";
  $conn->query($sql);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['id'])) {
    	// Atualizar tarefa
    	$taskId = $_POST['id'];
    	$title = $_POST['title'];
    	$description = $_POST['description'];

    	$sql = "UPDATE tarefas SET titulo = '$title', descricao = '$description' WHERE id = $taskId";
    	$conn->query($sql);
  	} else {
    	// Adicionar nova tarefa
    	$title = $_POST['title'];
    	$description = $_POST['description'];

    	$sql = "INSERT INTO tarefas (titulo, descricao) VALUES ('$title', '$description')";
    	$conn->query($sql);
  	}
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  	// Excluir tarefa
  	$taskId = $_GET['id'];

  	$sql = "DELETE FROM tarefas WHERE id = $taskId";
  	$conn->query($sql);
}

$conn->close();
?>
