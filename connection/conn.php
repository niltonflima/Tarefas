<?php
	$servername = "localhost";
	$username = "root";
	$password = "dbcmAdm";
	$dbname = "agenda";
	
	// Conectar ao banco de dados
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	  die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
	}
?>