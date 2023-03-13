<?php
ob_start();
session_start();

include ("logs/logs.php");
require_once '_action/functions.php';
$crud = new Crud();


if(isset($_POST['submit'])){
	if (isset($_POST['data'])) {
		$data = $_POST['data'];
		
	}else{
		$data = date_create()->format('Y-m-d');
	}
	$estado = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
	$id_assist = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$id_prof = filter_input(INPUT_POST, 'profissionais', FILTER_SANITIZE_NUMBER_INT);
	$id_serv = filter_input(INPUT_POST, 'servicos', FILTER_SANITIZE_NUMBER_INT);
	$tipo = filter_input(INPUT_POST, 'convenio', FILTER_SANITIZE_STRING);

	//Se ele estiver sendo desligado vai mudar o seu ativo de "sim" para "não" fazendo o mesmo sumir da agenda;
	if($estado=="Alta")
	{
		$ativo="N";
		include ("header/agenda-up-desliga.php");
	}


	$data = [
		"id_assist" => $id_assist,
		"data" => $data,
		"estado" => $estado,
		"id_prof" => $id_prof,
		"id_serv" => $id_serv,
		"tipo" => $tipo
	];

	$crud->create("atendimentos", $data);


	if ($estado == "Falta") {
		$faltas = $crud->verificarFaltas($id_assist);
		if($faltas >= 3) {
			echo "O paciente está com muitas faltas.";
		}else{
			echo "sem faltas";
		}
	}



	// try{
	// 	$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo)
	// 	VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo)";
	// 	$result = $conexao->prepare($insert);
	// 	$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
	// 	$result->bindParam(':data', $data, PDO::PARAM_STR);
	// 	$result->bindParam(':estado', $estado, PDO::PARAM_STR);
	// 	$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
	// 	$result->bindParam(':id_serv', $id_serv, PDO::PARAM_STR);
	// 	$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
	// 	$result->execute();
	// 	registraLog($id_assist, $id_serv, $id_prof, $estado, $_SESSION['nome'] );
	// 	header ("Location: relatorio");
	// }catch(PDOException $e){echo $e;}
}
?>