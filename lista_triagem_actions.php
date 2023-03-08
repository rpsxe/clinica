<?php 
require_once('conecta/conexao.php');

if (isset($_POST)) {
	
	$id_assist = $_POST['id_assist'];
	$id_lista = $_POST['id'];
	$estado = $_POST['estado'];
	$convenio = $_POST['convenio'];
	$id_prof = $_POST['prof'];
	$serv = $_POST['serv'];
	$data = $_POST['data'];


	$insert = "INSERT into `agenda_triagens` (id_assist, id_prof, data, convenio, estado, id_lista)	VALUES (:id_assist, :id_prof, :data, :convenio, :estado, :id_lista)";
	try{
		$result = $conexao->prepare($insert);
		$result->bindParam(':id_assist', $id_assist, PDO::PARAM_STR);
		$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
		$result->bindParam(':data', $data, PDO::PARAM_STR);
		$result->bindParam(':convenio', $convenio, PDO::PARAM_STR);
		$result->bindParam(':estado', $estado, PDO::PARAM_STR);
		$result->bindParam(':id_lista', $id_lista, PDO::PARAM_STR);
		$result->execute();
		$contar = $result->rowCount();
	}
	catch(PDOException $e){
		echo $e; die; exit;
	}

	switch ($estado) {
		case 0:
		$estado = 8;
		break;
		
		case 1:
		$estado = 9;
		break;

		default:
		$estado = 10;
		break;
	}



	$data_mudanca = date('Y-m-d');
	$update = "UPDATE lista_triagem SET estado=:estado, data=:data WHERE id=:id_lista";
	try{
		$result = $conexao->prepare($update);
		$result->bindParam(':id_lista', $id_lista, PDO::PARAM_INT);
		$result->bindParam(':estado', $estado, PDO::PARAM_STR);
		$result->bindParam(':data', $data_mudanca, PDO::PARAM_STR);
		$result->execute();
		$contar= $result->rowCount();
	}catch(PDOException $e){echo $e; die; exit;}

}


?>