<?php 

if (isset($_POST)) {
	
	include ("cabecalho.php");
	include ("logs/logs.php");

	$id_assist = $_POST['id_assist'];
	$data = date('Y-m-d');
	$estado = $_POST['status'];
	$id_prof = $_POST['idprof'];
	$id_serv = $_POST['serv'];
	$tipo = $_POST['convenio'];
	$obs = NULL;

	try{
		$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo, obs)
		VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo, :obs)";
		$result = $conexao->prepare($insert);
		$result->bindParam(':id_assist', $id_assist, PDO::PARAM_STR);
		$result->bindParam(':data', $data, PDO::PARAM_STR);
		$result->bindParam(':estado', $estado, PDO::PARAM_STR);
		$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
		$result->bindParam(':id_serv', $id_serv, PDO::PARAM_STR);
		$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
		$result->bindParam(':obs', $obs, PDO::PARAM_STR);
		$result->execute();
		registraLog($id_assist, $id_serv, $id_prof, $estado, $_SESSION['nome'] );
	}catch(PDOException $e){echo $e;}


	$estado = $_POST['estado'] + 1;
	$id_lista = $_POST['id_lista'];
	$update = "UPDATE lista_triagem SET estado=:estado, data=:data WHERE id=:id_lista";
	try{
		$result = $conexao->prepare($update);
		$result->bindParam(':id_lista', $id_lista, PDO::PARAM_INT);
		$result->bindParam(':estado', $estado, PDO::PARAM_STR);
		$result->bindParam(':data', $data, PDO::PARAM_STR);
		$result->execute();
		$contar= $result->rowCount();
	}catch(PDOException $e){echo $e; die; exit;}


	$id_delete = $_POST['id_agenda'];
	$select="DELETE from agenda_triagens WHERE id=:id_delete";
	try{
		$result=$conexao->prepare($select);
		$result->bindParam('id_delete',$id_delete, PDO::PARAM_INT);
		$result->execute();
		$contar= $result->rowCount();
		if($contar>0){
			header("Refresh:0, relatorio");
		}
	}catch(PDOException $e){echo $e;}

}


?>