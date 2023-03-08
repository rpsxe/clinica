<?php 
// 1.aqui vou atualizar para "N" todos os registros que tiverem o id_assist, id_prof e id_serv iguais aos que busquei anteriormente
$update = "UPDATE `agenda` SET  ativo=:ativo WHERE id_assist=:id_assist AND id_prof=:id_prof AND id_serv=:id_serv";
try{
	$result = $conexao->prepare($update);
	$result->bindParam(':ativo', $ativo, PDO::PARAM_STR);
	$result->bindParam(':id_assist', $id_assist, PDO::PARAM_INT);
	$result->bindParam(':id_prof', $id_prof, PDO::PARAM_INT);
	$result->bindParam(':id_serv', $id_serv, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
}catch(PDOException $e){echo $e;}
?>