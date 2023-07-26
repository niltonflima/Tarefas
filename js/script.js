$(document).ready(function() {
  	// Carregar tarefas existentes ao carregar a página
  	//loadTasks();
  	loadTasks_time();

  	// Enviar nova tarefa quando o formulário for enviado
  	$('#task-form').submit(function(e) {
    	e.preventDefault();
    	var taskTitle = $('#title').val();
    	var taskDescription = $('#description').val();
    	addTask(taskTitle, taskDescription);
  	});

  	// Atualizar tarefa quando clicar no botão de edição
  	$(document).on('click', '.edit-btn', function() {
    	var taskId = $(this).data('id');
    	var taskTitle = $(this).siblings('.title').text();
    	var taskDescription = $(this).siblings('.description').text();
    	updateTask(taskId, taskTitle, taskDescription);
  	});

  	// Excluir tarefa quando clicar no botão de exclusão
  	$(document).on('click', '.delete-btn', function() {
    	var taskId = $(this).data('id');
		var taskTitle = $(this).data('title');
    	var confirmDelete = confirm("Tem certeza de que deseja excluir esta tarefa?");
    	if (confirmDelete) {
      		deleteTask(taskId);
    	}
  	});
  
  	// Abrir janela modal para inserir uma nova tarefa quando o botão "Adicionar Nova Tarefa" for clicado
  	$(document).on('click', '.insert-btn', function() {
		$('#taskModalInsert').modal('show');
  	});

	//Pesquisa tarefas na data atual
	$(document).on('click', '.tarefa-hoj', function() {
		loadTasks('h');
	});
	//Pesquisa tarefas anteriores data atual
	$(document).on('click', '.tarefa-ant', function() {
		loadTasks('a');
	});	
	//Pesquisa tarefas posteriores data atual
	$(document).on('click', '.tarefa-pos', function() {
		loadTasks('p');
	});	
	//Pesquisa todas as tarefas
	$(document).on('click', '.tarefa-all', function() {
		loadTasks();
	});	
	//Pesquisa todas as tarefas concluídas
	$(document).on('click', '.tarefa-con', function() {
		loadTasks('c');
	});
	//Pesquisa todas as tarefas atrasadas
	$(document).on('click', '.tarefa-atr', function() {
		loadTasks('atr');
	});	
	
  	// Abrir janela modal quando o botão "Concluir" for clicado
  	$(document).on('click', '.concluir-btn', function() {											
    	var taskId = $(this).data('id');
    	$.ajax({
      		url: 'data/get_tarefas_details.php',
      		method: 'POST',
      		data: { id: taskId },
      		success: function(response) {
        		var task = JSON.parse(response);
				$('#bdaytime_ini').val(task.date_time);
				$('#concluir-btn-fim').data('id', taskId); // Armazenar o ID da tarefa
        		$('#taskModalDataFim').modal('show');
      		}
    	});													
  	});
  
  	// Enviar alterações da tarefa ao clicar em "Concluir"
  	$('#concluir-btn-fim').click(function() {
										  
    	var taskId = $(this).data('id');
		const datetime = $('#bdaytime_fim').val();
		const bdaytime_fim = datetime.replace('T', ' ').substring(0, 16) + ':00';
		if (bdaytime_fim == ':00'){
			alert('Campo de data é obrigatório.');
			return;
		}
	
   		var confirmConluir = confirm("Concluir esta tarefa?");
    	if (confirmConluir) {
			//alert('concluir-btn-fim.click');
			$.ajax({
		  		url: 'data/update_tarefas.php',
		  		method: 'POST',
		  		data: { id: taskId, sts: "c", date_end: bdaytime_fim },
		  		success: function(response) {
					loadTasks('con');
					loadTasks_time();
		  		}
			});		
			loadTasks('con');
    	}
	});  
  
  	// Abrir janela modal e carregar detalhes da tarefa quando o botão "Detalhes" for clicado
  	$(document).on('click', '.details-btn', function() {
    	var taskId = $(this).data('id');
    	$.ajax({
      		url: 'data/get_tarefas_details.php',
      		method: 'POST',
      		data: { id: taskId },
      		success: function(response) {
        		var task = JSON.parse(response);
        		$('#detalhe_titulo').val(task.title);
        		$('#detalhe_descricao').val(task.description);
				$('#detalhe_data').val(task.date_time);
				$('#detalhe_data_in').val(task.created_at);
				$('#detalhe_data_up').val(task.updated_at);
        		$('#taskModalDetalhe').modal('show');
      		}
    	});
  	});
  
  	// Abrir janela modal e carregar detalhes da tarefa quando o botão "Editar" for clicado
  	$(document).on('click', '.editar-btn', function() {
    	var taskId = $(this).data('id');
    	$.ajax({
      		url: 'data/get_tarefas_details.php',
      		method: 'POST',
      		data: { id: taskId },
      		success: function(response) {
        		var task = JSON.parse(response);
        		$('#updateTaskTitle').val(task.title);
        		$('#updateTaskDescription').val(task.description);
				$('#bdaytime_up').val(task.date_time);
        		$('#saveChangesBtn').data('id', taskId); // Armazenar o ID da tarefa
        		$('#taskModal').modal('show');
      		}
    	});
  	});

  	// Enviar alterações da tarefa ao clicar em "Salvar Alterações"
  	$('#saveChangesBtn').click(function() {
    	var taskId = $(this).data('id');
    	var taskTitle = $('#updateTaskTitle').val();
    	var taskDescription = $('#updateTaskDescription').val();
		var date_time = $('#bdaytime_up').val();
		if (date_time !== ''){	
    		updateTask(taskId, taskTitle, taskDescription,date_time);
			//location.reload(); // Atualizar a página completamente
			loadTasks('atu');
		} else {
			alert('O campo data é obrigatório.');
		}			
  	});
});

// Carregar tarefas existentes
function loadTasks(d) {
	$.ajax({
		url: 'data/load_tarefas.php',
		method: 'GET',
		data: { data: d },
		success: function(response) {
			$('#list-tarefas').html(response);
		}
	});
}

// Carregar tarefas existentes nas condições pendente, atual, futuras
function loadTasks_time(p,a,f) {
	$.ajax({
		url: 'data/load_tarefas_time.php',
		method: 'GET',
		data: { a: a, p: p, f: f },
		success: function(response) {
			$('#list-tarefas_time').html(response);
		}
	});
}

// Adicionar nova tarefa
function addTask(title, description) {
	const datetime = document.getElementById('bdaytime').value;
	const bdaytime = datetime.replace('T', ' ').substring(0, 16) + ':00';
	$.ajax({
		url: 'data/add_tarefas.php',
		method: 'POST',
		data: { title: title, description: description, bdaytime: bdaytime },
		success: function(response) {
			$('#title').val('');
			$('#description').val('');
			$('#bdaytime').val('');
			loadTasks('end');
			loadTasks_time();
		}
	});
}

// Atualizar tarefa existente
function updateTask(id, title, description, date_time) {
	const bdaytime_up = date_time.replace('T', ' ').substring(0, 16) + ':00';
	$.ajax({
		url: 'data/update_tarefas.php',
		method: 'POST',
		data: { id: id, title: title, description: description, bdaytime: bdaytime_up },
		success: function(response) {
			loadTasks();
		}
	});
}

// Excluir tarefa existente
function deleteTask(id) {
	$.ajax({
		url: 'data/delete_tarefas.php',
		type: 'DELETE',
    	data: JSON.stringify({ id: id }),
    	contentType: 'application/json',
		success: function(response) {
			loadTasks();
			loadTasks_time();
		}
	});
}
