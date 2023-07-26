# tarefas
Sistema CRUD para gerenciamento básico de dados e envolve operações fundamentals de criação (Create), leitura (Read), atualização (Update) e exclusão (Delete) de informagoes em um banco de dados.

Instruções para a instalação do sistema:
1. Crie um banco de dados no MySql com o nome "agenda".
2. Crie a estrutura da tabela chamada "tarefas". 
A estrutura da tabela está disponível na pasta "sql" em um arquivo com o nome tb_tarefa.txt.
3. Envie o arquivo "index.html" e as pastas "connection", "data" e "js" para o servidor onde o sistema será executado.
4. Edite o arquivo "conn.php" com as informações de conexão necessárias para se conectar ao banco de dados.

Utilizando o sistema:
1. Abra o endereço web onde o sistema foi instalado.
2. Será exibido uma tela com um único botão identificado como "Adicionar nova tarefa".
3. Conforme novas tarefas são adicionadas, novos botões de controle serão exibidos.
4. Quando uma tarefa é criada, ela é exibida com os seguintes botões:
 - Editar: Permite editar as informações da tarefa.
 - Detalhes: Mostra os detalhes da tarefa cadastrada.
 - Concluída: Permite marcar a tarefa como concluída, informando a data de conclusão.
 - Excluir: Remove imediatamente uma tarefa após a confirmação.
