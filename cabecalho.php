<!DOCTYPE html>
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=IBM+Plex+Serif" rel="stylesheet">
<?php

include ("conecta/conexao.php");
include ("header/verifica.php");
include ("includes/infos-num.php");
// date_default_timezone_set('America/Sao_Paulo');
date_default_timezone_set("America/Fortaleza");
if(isset($_GET['id']))
{
	$verificaId=trim(strip_tags($_GET['id']));
	if (is_numeric($verificaId)){}else{
		header("Location: inicio"); exit;
	}
}
?>
<head>
	<html lang="pt-br">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jqueryform.js"></script>
</head>


<script>
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		window.print();
		document.body.innerHTML = restorepage;
	}
</script>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" title="Este é o sistema gestor do Caminho da Luz, seja bem vindo!" href="javascript:void(0)">Caminho da Luz</a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        

			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li title="Página inicial"><a href="inicio">Inicio</a></li>
					<li title="Realizar cadastros"><a href="cadastrar">Cadastrar</a></li>
					<li title="Lista de cadastrados"><a href="registros">Registros</a></li>
					<li title="Verificar agenda"><a href="<?php echo date("N"); ?>" >Agenda</a></li> 
					<!-- <li title="Verificar agenda"><a href="agenda" >Agenda</a></li> -->
					<li class="dropdown" title="Relatórios mensais">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li title="Relatório de atividades diária"><a href="relatorio" >Relatório diário</a></li>
						<li title="Relatório de de faltas semanais"><a href="relatorio-faltas.php" >Relatório de faltas</a></li>
					
						</ul>

					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Listas <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li title="Ver lista do serviço social"><a href="lista-servsoc" >Triagem Serviço Social</a></li>
							<li title="Ver lista de triagens"><a href="triagens" >Triagem Psicologia</a></li>
							<li title="Ver lista de avaliação"><a href="lista-avaliacao" >Lista de Avaliação por Especialidade</a></li>
							<li title="Ver lista"><a href="lista-convenios" >Lista de Convênios</a></li>
							
							<?php if($_SESSION['nivel'] >= 1){ ?>
							<li title="Lista de Espera"><a href="lista-espera" >Lista de Espera</a></li><?php } ?>
						</ul>
					</li>


					<li title="Agenda de todos os profissionais"><a href="minha-agenda">Minha Agenda</a></li>
					<!--<li><a href="administrativo">Administrativo</a></li> -->
				</ul>
				<form class="navbar-form navbar-right" method ="post" action="pesquisa" role="search">
					<div class="form-group input-group">
						<input type="text" class="form-control" name="busca" placeholder="Procurar.." required>
						<span class="input-group-btn">
						</span>        
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="sair" onClick="return confirm('Deseja realmente sair?')">Sair</a></li>
				</ul>
			</div>
		</div>
	</nav>



