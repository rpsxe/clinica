<?php
ob_start();
session_start();
	//verifica se o usuário já está logado no sistema
if (!isset($_SESSION['usuarioconecta']) && (!isset($_SESSION['senhaconecta']))){
	header ("Location: login"); exit;
}


	/* PÁGINA DE VERIFICAÇÃO
	AQUI VAI SER VERIFICADO SE O USUÁRIO TÁ CONECTADO NO SISTEMA
	SE NÃO ESTIVER CONECTADO ELE VAI SER REDIRECIONADO PARA A TELA DE LOGIN
	CASO JÁ ESTEJA LOGADO ELE VAI PERMITIR ENTRAR NO SISTEMA */
?>