
<?php 
include("conecta/conexao.php");

$data = '07/2021';
$verifica = 0;
$num = 1;
$contador = 1;
$smed = NULL;
$saude = NULL;
$centro = NULL;
$cluz = NULL;
$assistencia = NULL;
$presente = 0;
$falta = 0;
$faltajustificada = 0;
$alta = 0;
$desligado = 0; 
$dispensado = 0;
$profissionalausente = 0;
$inserido = 0;
$profissionalemferias = 0;
$profissionalematestado = 0;
$festividades = 0; 
$informacoessobre = 0;


// for ($i=1; $i <= 28 ; $i++) { 
$presente = 0;
$falta = 0;
$faltajustificada = 0;
$alta = 0;
$desligado = 0; 
$dispensado = 0;
$profissionalausente = 0;
$inserido = 0;
$profissionalemferias = 0;
$profissionalematestado = 0;
$festividades = 0; 
$informacoessobre = 0;

	$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome, assistidos.id_assist as id
	FROM (((atendimentos
	INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
	INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
	INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE date_format(data, '%m/%Y')='$data' AND tipo = 'CLuz'   ORDER BY  data ASC";
	$result=$conexao->prepare($select);
	$result->bindParam(':dia', $dia, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){	
		// echo '	<div class="table-responsive">  				
		// <table class="table">
		// <thead style="background: white;">
		// </thead>
		// <tbody>';
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$nomeServ = $linha->serv_nome;	
			// $tipo=$linha->tipo;
			// $nome = $linha->assist_nome;
			// $nome = implode('-', explode(' ', $nome));
			// $id_assist = $linha->id;
		// if ($id_assist === $verifica) {
		// 	$verifica = $id_assist;
		// }else{

			?>
		<!-- 	<tr>

				<td><?php	echo $num++; ?></td>
				<td><?php	echo $linha->assist_nome; ?></td>
				<td><?php	echo $linha->p_nome; ?></td>
				<td><?php	echo $linha->serv_nome; ?></td>
				<td><?php	echo $linha->tipo; ?></td>
				<td><?php	echo $linha->estado; ?></td>
				 <td><?php	echo date('d/m/Y',  strtotime($linha->data)); ?></td>  
				</tr> -->
				<?php
			// $verifica = $id_assist;
		// }


				switch ($linha->estado) {
					case 'Presente':
					$presente++;
					break;
					case 'Falta':
					$falta++;
					break;
					case 'Falta Justificada':
					$faltajustificada++;
					break;
					case 'Dispensado':
					$dispensado++;
					break;
					case 'Inserido':
					$inserido++;
					break;
					case 'Desligado':
					$desligado++;
					break;
					case 'Alta':
					$alta++;
					break;
					case 'Profissional Ausente':
					$profissionalausente++;
					break;
					case 'Profissional em Férias':
					$profissionalemferias++;
					break;
					case 'Profissional em Atestado':
					$profissionalematestado++;
					break;
					case 'Festividades':
					$festividades++;
					break;
					case 'Informações Sobre':
					$informacoessobre++;
					break;

					default:
					# code...
					break;
				}

				switch ($linha->tipo) {
					case 'SMED':
					$smed++;
					break;
					case 'Saúde':
					$saude++;
					break;
					case 'Centro':
					$centro++;
					break;
					case 'CLuz':
					$cluz++;
					break;
					case 'Assistencia':
					$assistencia++;
					break;

					default:
					# code...
					break;
				}

			}	
		// echo $contar;			




echo '<br><br><br><br>';
echo '<table>';
echo '<thead><th>'.$nomeServ.'</th><th></th></thead>';
echo '<tbody>';
echo "<tr><td>Presente</td><td>" . $presente . "</td></tr>";
echo "<tr><td>Falta</td><td>" . $falta . "</td></tr>";
echo "<tr><td>Falta Justificada</td><td>" . $faltajustificada . "</td></tr>";
echo "<tr><td>Dispensado</td><td>" . $dispensado . "</td></tr>";
echo "<tr><td>Alta</td><td>" . $alta . "</td></tr>";
echo "<tr><td>Desligado</td><td>" . $desligado . "</td></tr>";
echo "<tr><td>Inserido</td><td>" . $inserido . "</td></tr>";
echo "<tr><td>Profissional Ausente</td><td>" . $profissionalausente . "</td></tr>";
echo "<tr><td>Profissional em Férias</td><td>" . $profissionalemferias . "</td></tr>";
echo "<tr><td>Profissional em Atestado</td><td>" . $profissionalematestado . "</td></tr>";
echo "<tr><td>Festividades</td><td>" . $festividades . "</td></tr>";
echo "<tr><td>Informações Sobre</td><td>" . $informacoessobre . "</td></tr>";
echo '</tbody></table>';


	}else{} // FIM IF $CONTAR




// echo "SMED " . $smed . "<br>";
// echo "Saúde " . $saude . "<br>";
// echo "Centro " . $centro . "<br>";
// echo "CLuz " . $cluz . "<br>";
// echo "Assistencia " . $assistencia . "<br>";


// }


?>
</tbody>
</table>
</div>