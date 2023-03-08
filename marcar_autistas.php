<?php 
include("conecta/conexao.php");
$autista = $_POST['autista'];
$id = $_POST['id_assist'];
$update = "UPDATE `assistidos` SET autista=:autista WHERE id_assist=:id";
try{
	$result = $conexao->prepare($update);
	$result->bindParam(':id', $id, PDO::PARAM_INT);
	$result->bindParam(':autista', $autista, PDO::PARAM_INT);
	$result->execute();
	$contar = $result->rowCount();
}
catch(PDOException $e){
	echo $e;}
	?>