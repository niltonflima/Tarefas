<?php
// Conectar ao banco de dados
include("../connection/conn.php");

$dataAtual = date('Y-m-d');
//Mostra os botões das tarefas
echo '
<button class="insert-btn btn btn-default" type="button">
	<div class="card" style="width: 18rem;">
		<div class="card-body">
			<h4 class="card-title">Adicionar Nova <br>Tarefa</h4>
			<h6 class="card-subtitle mb-2">Clique e adicione uma <br>nova tarefa</h6>

		</div>
	</div>
</button>';			

$query_all = "SELECT id FROM tarefas";
$resultado_all = $conn->query($query_all);
	
if ($resultado_all->num_rows > 0){
	echo '
	<button class="tarefa-all btn btn-default" type="button">
		<div class="card" style="width: 18rem;">
			<div class="card-body">
				<h4 class="card-title">Todas as tarefas</h4>
				<h6 class="card-subtitle mb-2">Clique e veja todas <br>as tarefas existentes</h6>
				<a href="#" class="card-link">Total de: '.$resultado_all->num_rows.'</a>
			</div>
		</div>
	</button>';				

	$query_a = "SELECT date_time, COUNT(CASE WHEN date_time < '$dataAtual' THEN 1 END) AS anterior FROM tarefas order BY anterior";
	$resultado_a = $conn->query($query_a);
	if ($resultado_a->num_rows > 0) {
		$row = $resultado_a->fetch_assoc();
		if ($row['anterior'] > 0)
			echo '
			<button class="tarefa-ant btn btn-default" type="button">
				<div class="card" style="width: 18rem;">
					<div class="card-body">
						<h4 class="card-title">Anteriores</h4>
						<h6 class="card-subtitle mb-2">Clique e veja todas <br>as tarefas anteriores</h6>
						<a href="#" class="card-link">Total de: '.$row['anterior'].'</a>
					</div>
				</div>
			</button>';					
	}
	
	$query_h = "SELECT date_time, COUNT(CASE WHEN date_time like '$dataAtual%' THEN 1 END) AS hoje FROM tarefas order BY hoje";
	$resultado_h = $conn->query($query_h);
	if ($resultado_h->num_rows > 0) {
		$row = $resultado_h->fetch_assoc();
		if ($row['hoje'] > 0)
			echo '
			<button class="tarefa-hoj btn btn-default" type="button">
				<div class="card" style="width: 18rem;">
					<div class="card-body">
						<h4 class="card-title">Tarefas para hoje</h4>
						<h6 class="card-subtitle mb-2">Clique e veja todas <br>as tarefas para hoje</h6>
						<a href="#" class="card-link">Total de: '.$row['hoje'].'</a>
					</div>
				</div>
			</button>';				
	}
	
	$dataAtual = date('Y-m-d 23:59:00');
	$query_p = "SELECT date_time, COUNT(CASE WHEN date_time > '$dataAtual' THEN 1 END) AS posterior  FROM tarefas order BY posterior";
	$resultado_p = $conn->query($query_p);
	if ($resultado_p->num_rows > 0) {
		$row = $resultado_p->fetch_assoc();
		if ($row['posterior'] > 0)
			echo '
			<button class="tarefa-pos btn btn-default" type="button">
				<div class="card" style="width: 18rem;">
					<div class="card-body">
						<h4 class="card-title">Posteriores</h4>
						<h6 class="card-subtitle mb-2">Clique e veja todas <br>as tarefas posteriores</h6>
						<a href="#" class="card-link">Total de: '.$row['posterior'].'</a>
					</div>
				</div>
			</button>';				
	}
	
	$query_conlui = "SELECT id FROM tarefas where sts = 'c'";
	$resultado_conclui = $conn->query($query_conlui);
	if ($resultado_conclui->num_rows > 0)
		echo '
		<button class="tarefa-con btn btn-default" type="button">
			<div class="card" style="width: 18rem;">
				<div class="card-body">
					<h4 class="card-title">Concluídas</h4>
					<h6 class="card-subtitle mb-2">Clique e veja todas <br>as tarefas concluídas</h6>
					<a href="#" class="card-link">Total de: '.$resultado_conclui->num_rows.'</a>
				</div>
			</div>
		</button>';
	
	$dataAtual = date('Y-m-d H:i:s');
	$query_atrasa = "SELECT id FROM tarefas where sts <> 'c' and date_time < '$dataAtual' ";
	$resultado_atrasa = $conn->query($query_atrasa);
	if ($resultado_atrasa->num_rows > 0)
		echo '
		<button class="tarefa-atr btn btn-default" type="button">
			<div class="card" style="width: 18rem;">
				<div class="card-body">
					<h4 class="card-title">Atrasadas</h4>
					<h6 class="card-subtitle mb-2">Clique e veja todas <br>as tarefas atrasadas</h6>
					<a href="#" class="card-link">Total de: '.$resultado_atrasa->num_rows.'</a>
				</div>
			</div>
		</button>';
		
} else {
	echo '
	<div class="col-sm-12 text-center">
		<h5 class="card-title" title="Gerenciamento de Tarefas">Nenhuma tarefa encontrada. Clique em [<strong>Adicionar Nova Tarefa</strong>] para começar.</h5>
	</div>';
}
/*echo '
<button style="float:left;" type="button" class="btn btn-outline-dafault" title="Atualiza informações das tarefas." onclick="loadTasks_time()">
	<span  class="material-icons">cached</span><span class="material-icons">arrow_outward</span>
</button>';*/
	
$conn->close();
?>