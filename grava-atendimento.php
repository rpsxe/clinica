<meta charset="utf-8">
<?php
$d = date("N");
	//Incluindo cabeçalho
include ("cabecalho.php");
include ("logs/logs.php");
$data= date("Y/m/d");
$estado=$_POST['status'];
$id_assist=$_POST['id_assist'];
$id_prof=$_POST['id_prof'];
$id_serv=$_POST['id_serv']; 
$tipo=$_POST['conv'];
$id_agenda=$_POST['id_agenda'];



	//Se ele estiver sendo desligado vai mudar o seu ativo de "sim" para "não" fazendo o mesmo sumir da agenda;
if($estado=="Desligado" OR $estado=="Alta")
{
	$ativo="N";
	include ("header/agenda-up-desliga.php");
}


try{
	$insert = "INSERT into `atendimentos` (id_assist,data,estado,id_prof,id_serv,tipo, obs)
	VALUES (:id_assist, :data, :estado, :id_prof, :id_serv, :tipo, :id_agenda)";
	$result = $conexao->prepare($insert);
	$result->bindParam(':id_assist', $id_assist, PDO::PARAM_STR);
	$result->bindParam(':data', $data, PDO::PARAM_STR);
	$result->bindParam(':estado', $estado, PDO::PARAM_STR);
	$result->bindParam(':id_prof', $id_prof, PDO::PARAM_STR);
	$result->bindParam(':id_serv', $id_serv, PDO::PARAM_STR);
	$result->bindParam(':tipo', $tipo, PDO::PARAM_STR);
	$result->bindParam(':id_agenda', $id_agenda, PDO::PARAM_STR);
	$result->execute();
	registraLog($id_assist, $id_serv, $id_prof, $estado, $_SESSION['nome'] );
	header ("Refresh: 0, relatorio");
}catch(PDOException $e){echo $e;}


// if($estado == "Falta"){
// 	$falta = NULL;
// 	$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
// 	FROM (((atendimentos
// 	INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
// 	INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
// 	INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE atendimentos.id_assist='$id_assist' ORDER BY id DESC LIMIT 3";
// 	$result=$conexao->prepare($select);
// 	$result->execute();
// 	$contar= $result->rowCount();
// 	if($contar>0){
// 		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
// 			if ($linha->estado == "Falta"){
// 				$falta++;
// 				$nomeZap = explode (' ', $linha->assist_nome);
// 			}
// 		}
// 	}
// }else{
// 	$falta = NULL;
// 	header ("Refresh: 0, relatorio");
// }

// if ($falta == 3) {
// 	$select = "SELECT assist_resp.*, resp.telefone as telefone
// 	FROM ((assist_resp
// 	INNER JOIN assistidos ON assist_resp.id_assist = assistidos.id_assist)
// 	INNER JOIN resp ON assist_resp.cpf = resp.cpf) WHERE assist_resp.id_assist='$id_assist'";
// 	try{
// 		$result=$conexao->prepare($select);
// 		$result->execute();
// 		$contar= $result->rowCount();
// 		if($contar>0){
// 			while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
// 				$telefone = $linha->telefone;
// 			}
// 		}
// 	}catch(PDOException $e){
// 		echo $e;
// 	}
// 	$mensagem = "Olá, aqui é do Caminho da Luz, notamos que o/a ".$nomeZap[0]." faltou aos últimos atendimentos, gostariamos de saber se está acontecendo alguma coisa?! Estamos aqui para ajudar, a presença dele(a) é importante para nós, att UEB Clínica.";
// 	$mensagem = implode('%20', explode(' ', $mensagem));


// 	echo '<div class="container"><br><br>
// 	<h1 style="text-align: justify">Olá, notei que o '.$nomeZap[0].' faltou aos últimos três atendimentos e não justificou, gostaria de entrar em contato com os responsáveis do mesmo? <a href="https://api.whatsapp.com/send?phone=5553'.$telefone.'&text='.$mensagem.'" target="_blank">Entrar em contato</a></h1>';
// 	echo '</div>';
// }else{
// 	$falta = NULL;
// 	header ("Refresh: 0, relatorio");
// }

?>

