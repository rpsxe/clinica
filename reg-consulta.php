<?php
ob_start();
session_start();

include ("conecta/conexao.php");
include ("logs/logs.php");

if(isset($_POST['submit'])){
	$data= date("Y/m/d");
	$estado=$_POST['status'];
	$id_assist=$_GET['id'];
	$id_prof=$_POST['profissionais'];
	$id_serv=$_POST['servicos']; 
	$tipo=$_POST['convenio'];

	//Se ele estiver sendo desligado vai mudar o seu ativo de "sim" para "não" fazendo o mesmo sumir da agenda;
	if($estado=="Alta")
	{
		$ativo="N";
		include ("header/agenda-up-desliga.php");
	}

	try{
		$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo)
		VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo)";
		$result = $conexao->prepare($insert);
		$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
		$result->bindParam(':data', $data, PDO::PARAM_STR);
		$result->bindParam(':estado', $estado, PDO::PARAM_STR);
		$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
		$result->bindParam(':id_serv', $id_serv, PDO::PARAM_STR);
		$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
		$result->execute();
		registraLog($id_assist, $id_serv, $id_prof, $estado, $_SESSION['nome'] );
		header ("Location: relatorio");
	}catch(PDOException $e){echo $e;}
}
?>