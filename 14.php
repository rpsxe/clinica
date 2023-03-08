

<?php 
require_once('conecta/conexao.php');

echo '<table><thead><th>Assistido</th><th>Serviço</th></thead><tbody>';
$cont = 1;
$verifica = 0;
$select = "SELECT *, assistidos.nome nome, assistidos.id_assist id, servicos.nome serv_nome, assistidos.autista autista, servicos.id id_serv
FROM((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN servicos ON agenda.id_serv = servicos.id)
WHERE ativo = 'S' AND tipo='SMED'  ORDER BY assistidos.nome ASC";
$result = $conexao->prepare($select);
$result->execute();
$contar = $result->rowCount();
if($contar > 0){
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$id_assist = $linha->id;
	if ($id_assist === $verifica) {
			$verifica = $id_assist;
		}else{
		// $cont = 1;
		$verifica = $id_assist;
		echo '<tr><td>'.$cont++.'</td><td>' . $linha->nome . '</td><td>' .$linha->tipo. '</td></tr>';
		}

	}
}
echo $contar;
echo '</tbody></table>';
?>

<br><br>




<?php 
require_once('conecta/conexao.php');

echo '<table><thead><th>Assistido</th><th>Serviço</th></thead><tbody>';
$cont = 1;
$verifica = 0;
$select = "SELECT *, assistidos.nome nome, assistidos.id_assist id, servicos.nome serv_nome, assistidos.autista autista, servicos.id id_serv
FROM((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN servicos ON agenda.id_serv = servicos.id)
WHERE ativo = 'S' AND tipo='Saúde'  ORDER BY assistidos.nome ASC";
$result = $conexao->prepare($select);
$result->execute();
$contar = $result->rowCount();
if($contar > 0){
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$id_assist = $linha->id;
	if ($id_assist === $verifica) {
			$verifica = $id_assist;
		}else{
		// $cont = 1;
		$verifica = $id_assist;
		echo '<tr><td>'.$cont++.'</td><td>' . $linha->nome . '</td><td>' .$linha->tipo. '</td></tr>';
		}

	}
}
echo $contar;
echo '</tbody></table>';
?>

<br><br>

<!-- <?php 
require_once('conecta/conexao.php');

echo '<table><thead><th>Assistido</th><th>Serviço</th></thead><tbody>';
$cont = 1;
$verifica = 0;
$select = "SELECT *, assistidos.nome nome, servicos.nome serv_nome, assistidos.autista autista, servicos.id id_serv
FROM((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN servicos ON agenda.id_serv = servicos.id)
WHERE ativo = 'S' AND tipo='SMED'  ORDER BY assistidos.nome ASC";
$result = $conexao->prepare($select);
$result->execute();
$contar = $result->rowCount();
if($contar > 0){
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$id_assist = $linha->tipo;
	if ($id_assist === $verifica) {
			$verifica = $id_assist;
		}else{
$cont = 1;
			$verifica = $id_assist;
		}
		echo '<tr><td>'.$cont++.'</td><td>' . $linha->nome . '</td><td>' .$linha->serv_nome. '</td><td>' .$linha->tipo. '</td></tr>';

	}
}
echo $contar;
echo '</tbody></table>';
?>
<br><br> -->

<!-- 

<?php 
require_once('conecta/conexao.php');

echo '<table><thead><th>Assistido</th><th>Serviço</th></thead><tbody>';
$cont = 1;
$verifica = 0;
$select = "SELECT *, assistidos.nome nome, servicos.nome serv_nome, assistidos.autista autista, servicos.id id_serv
FROM((agenda
INNER JOIN assistidos ON agenda.id_assist = assistidos.id_assist)
INNER JOIN servicos ON agenda.id_serv = servicos.id)
WHERE ativo = 'S' AND tipo!='Saúde' AND tipo!='SMED'  ORDER BY assistidos.nome ASC";
$result = $conexao->prepare($select);
$result->execute();
$contar = $result->rowCount();
if($contar > 0){
	while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
		$id_assist = $linha->tipo;
	if ($id_assist === $verifica) {
			$verifica = $id_assist;
		}else{
$cont = 1;
			$verifica = $id_assist;
		}
		echo '<tr><td>'.$cont++.'</td><td>' . $linha->nome . '</td><td>' .$linha->serv_nome. '</td><td>' .$linha->tipo. '</td></tr>';

	}
}
echo $contar;
echo '</tbody></table>';
?> -->