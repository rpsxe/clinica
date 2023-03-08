
<?php 
include("conecta/conexao.php");
echo '<div style="display: none;">';
include("cabecalho.php");
echo '</div>';
?>
<div class="container">
	<form action="14.php">
		<div class="row">
			<div class="col-lg-6">
				<?php include("includes/prof.php"); ?>
			</div>
			<div class="col-lg-6">
				<select name="tipo">
					<option value="SMED">SMED</option>
					<option value="Saúde">Saúde</option>
					<option value="CLuz">CLuz</option>
					<option value="Assistencia">Assistencia</option>
				</select>
			</div>
		</div>


		<input type="submit" value="Enviar">
	</form>
</div>

<?php 
if(isset($_POST['subtmit'])){
	$dataIni = '2018/12/31';
	$prof = $_GET['profissionais'];
	$tipo = $_GET['tipo'];
	$dataFim = '2018/01/01';
	$cont = 0;$faltas = 0;$saude=0;$smed=0;$desliga=0;$fj=0;  $num=0; $ins=0;$dis=0; $alta=0;$pfaus=0; $pferias=0; $cluz=0; $assist = 0;
	$select = "SELECT atendimentos.*, atendimentos.id as id_at, profissionais.nome as p_nome, servicos.nome as serv_nome, assistidos.nome as assist_nome
	FROM (((atendimentos
	INNER JOIN assistidos ON atendimentos.id_assist = assistidos.id_assist)
	INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id)
	INNER JOIN servicos ON atendimentos.id_serv = servicos.id) WHERE id_prof='$prof' AND tipo='$tipo' AND (data BETWEEN '$dataFim' AND '$dataIni') ORDER BY tipo, assist_nome ASC";
	$result=$conexao->prepare($select);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){ $num=1;
		echo '<div class="table-responsive" id="tabela">  				
		<table class="table">
		<thead style="background: white;">
		<tr >
		<th>
		<th>Nome</th>
		<th>Atendimento</th>
		<th>Convênio</th>
		</tr>
		</thead>
		<tbody>';
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) { 
			$idAluno =  $linha->id_assist;
			if($ver == $idAluno){
			// echo '<tr> ';
			// echo '<td>'.$linha->assist_nome.'</td>'; 
			// echo '<td>'.$linha->serv_nome.'</td>'; 
			// echo '</tr>'; 
			// $ver = $idAluno;
			// $col=1;
			// $ver = $idAluno;	

			}else{

				echo '<tr> ';
				echo '<td>'.$num++.'</td>'; 
				echo '<td>'.$linha->assist_nome.'</td>'; 
				echo '<td>'.$linha->serv_nome.'</td>'; 
				echo '<td>'.$linha->tipo.'</td>'; 
				echo '</tr>';
				$ver = $idAluno;

			}

			$prof = $linha->p_nome;
		// $tipo=$linha->tipo;
		// $estado = $linha->estado;
		// if($tipo=="SMED" && $estado=="Presente"){$smed++;}
		// if($tipo=="Saúde" && $estado=="Presente"){$saude++;}
		// if($tipo=="CLuz" && $estado=="Presente"){$cluz++;}
		// if($tipo=="Assistencia" && $estado=="Presente"){$assist++;}
		// if($estado=="Presente"){$cont++;}
		// if($estado=="Falta"){$faltas++;}
		// if($estado=="Falta Justificada"){$fj++;}
		// if($estado=="Desligado"){$desliga++;}
		// if($estado=="Inserido"){$ins++;}
		// if($estado=="Dispensado"){$dis++;}
		// if($estado=="Alta"){$alta++;}
		// if($estado=="Profissional Ausente"){$pfaus++;}
		// if($estado=="Profissional em Férias"){$pferias++;}
		// $profi_nome = $linha->p_nome;
		}
	}
}
?>

</tbody>
</table>
<!-- <h2 class="text-center">Atendimentos entre <?php echo date('d/m/Y', strtotime($dataIni)); ?> à <?php echo date('d/m/Y', strtotime($dataFim)); ?></h2>
<p id="presencas" class="text-center"></p><br>
<div class="table-responsive" id="tabela">  				
	<table class="table">
		<thead style="background: white;">
			<tr >
				<th>Profissional</th>
				<th>Presenças</th>
				<th>Faltas</th>
				<th>Faltas Justificadas</th>
				<th>Desligados</th>
				<th>Inseridos</th>
				<th>Dispensados</th>
				<th>Altas</th>
				<th>Profissionais Ausentes</th>
				<th>Profissional em Férias</th>
				<th>SMED</th>
				<th>Saúde</th>
				<th>C.Luz</th>
				<th>Assistência</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $profi_nome; ?></td>
				<td><?php echo $cont; ?></td>
				<td><?php echo $faltas; ?></td>
				<td><?php echo $fj; ?></td>
				<td><?php echo $desliga; ?></td>
				<td><?php echo $ins; ?></td>
				<td><?php echo $dis; ?></td>
				<td><?php echo $alta; ?></td>
				<td><?php echo $pfaus; ?></td>
				<td><?php echo $pferias; ?></td>
				<td><?php echo $smed; ?></td>
				<td><?php echo $saude; ?></td>
				<td><?php echo $cluz; ?></td>
				<td><?php echo $assist; ?></td>
				
			</tr>
		</tbody>
	</table>
</div> -->