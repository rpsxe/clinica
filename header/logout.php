<?php
ob_start();
session_start();
	// vai destruir a sessão criada
	session_destroy();
	// vai limpar dados
	session_unset($_SESSION['usuarioconecta']);
	session_unset($_SESSION['senhaconecta']);
	// vai redirecionar para "index.php"
	header ("Location: login");
?>