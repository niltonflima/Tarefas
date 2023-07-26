<?php
// Conectar ao banco de dados
include("../connection/conn.php");

$data = $_GET['data'];

$limit = '';
$retorno_title = '';

if ($data == 'h'){
	$data = 'where date_time like "'.date('Y-m-d').'%" ';
	$retorno_title = 'Tarefas para hoje.';
} elseif ($data == 'a') {
	$data = 'where date_time < "'.date('Y-m-d').'" ';
	$retorno_title = 'Tarefas anteriores ao dia de hoje.';
} elseif ($data == 'p') {
	$data = 'where date_time > "'.date('Y-m-d 23:59:00').'" ';
	$retorno_title = 'Tarefas posteriores ao dia de hoje.';
} elseif ($data == 'end') {
	$limit = ' LIMIT 1';
	$retorno_title = 'Útima tarefa cadastrada.';
} elseif ($data == 'c') {
	$data = 'where sts = "c" ';
	$retorno_title = 'Tarefas concluídas.';	
} elseif ($data == 'atr') {
	$data = 'where sts <> "c" and date_time < "'.date('Y-m-d H:i:s').'" ';
	$retorno_title = 'Tarefas atrasadas.';	
} elseif ($data == 'con') {
	$data = 'where sts = "c" and date_end <> "" ';
	$limit = ' LIMIT 1';
	$retorno_title = 'Tarefa concluída.';	
} elseif ($data == 'atu') {
	$data = 'where updated_at >= "'.date('Y-m-d H:i:s').'" ';
	$limit = ' LIMIT 1';
	$retorno_title = 'Tarefa editada.';	
} else {
	$data = '';
	$retorno_title = 'Todas as tarefas.';
}

// Selecionar todas as tarefas do banco de dados
$sql = "SELECT * FROM tarefas $data order by date_time asc  $limit";
$result = $conn->query($sql);

// Exibi as tarefas em uma lista de cards
if ($result->num_rows > 0) {
	if ($retorno_title !== ''){
		echo '<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title" title="Título">'.$retorno_title.'</h4>
				</div>
			</div>
		</div>';
	}
	while ($row = $result->fetch_assoc()) {
		$created_at = new DateTime($row['created_at']);
		$format_created_at = $created_at->format('d/m/Y H:i:s');
	
		$updated_at = new DateTime($row['updated_at']);
		$format_updated_at = $updated_at->format('d/m/Y H:i:s');
	
		$date_time = new DateTime($row['date_time']);
		$format_date_time = $date_time->format('d/m/Y H:i:s');	
	
		$date_end = new DateTime($row['date_end']);
		$format_date_end = $date_end->format('d/m/Y H:i:s');
	
		$disabled = "";
		$title = "";
		$conlui = "";
	
		if ($row['sts'] == 'c'){
			$disabled = "disabled";
			$title = "Tarefa já está concluída.";
			$conlui = "<strong> e Concluída em</strong>: ".$format_date_end;
		}	

		echo'
		<div class="col-sm-6">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title" title="Título"><strong>Título</strong>:<br>'. htmlspecialchars($row['title']) .'</h4>
					<p class="card-text" title="Descrição"><strong>Descrição</strong>:<br>'. htmlspecialchars(mb_strimwidth($row['description'],0,100,"...")) .'</p>
					<p class="card-text" title="Data da tarefa"><strong>Agendada para</strong>: '. $format_date_time . $conlui .'</p>
					<p class="task-description">Criada: ' . $format_created_at . ' - Atualizada: '. $format_updated_at.'</p>
					<button '. $disabled .' title="'.$title.'" style="white-space: normal;" class="editar-btn btn btn-success" data-id=' . $row['id'] . '>Editar</button>
					<button class="details-btn btn btn-warning" data-id=' . $row['id'] . '>Detalhar</button>
					<button '. $disabled .' title="'.$title.'" class="concluir-btn btn btn-default" data-id=' . $row['id'] . '>Conluída</button>
					<button class="delete-btn btn btn-danger" data-id=' . $row['id'] . '>Excluir</button>
				</div>
			</div>
		</div>';
	}
} else {
	echo '
	<div class="col-sm-12 text-center">
		<h3 class="card-title" title="Gerenciamento de Tarefas">...</h3>
	</div>';
}
$conn->close();
?>

