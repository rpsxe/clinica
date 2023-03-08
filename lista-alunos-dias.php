<?php 

$select = "SELECT * FROM profissionais WHERE id=:prof";
try{
	$result=$conexao->prepare($select);
	$result->bindParam(':prof', $prof, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$profNome=$linha->nome;
		}
	}
}catch(PDOException $e){
	echo $e;
}

$select = "SELECT * FROM servicos WHERE id=:servico";
try{
	$result=$conexao->prepare($select);
	$result->bindParam(':servico', $servico, PDO::PARAM_INT);
	$result->execute();
	$contar= $result->rowCount();
	if($contar>0){
		while ($linha = $result->FETCH(PDO::FETCH_OBJ)) {
			$servNome=$linha->nome;
		}
	}
}catch(PDOException $e){
	echo $e;
}




if($mes==1){
	$nomemes="Janeiro";
	$meuArray []= "2";
	$meuArray []= "3";
	$meuArray []= "4";
	$meuArray []= "5";
	$meuArray []= "8";
	$meuArray []= "9";
	$meuArray []= "10";
	$meuArray []= "11";
	$meuArray []= "12";
	$meuArray []= "15";
	$meuArray []= "16";
	$meuArray []= "17";
	$meuArray []= "18";
	$meuArray []= "19";
	$meuArray []= "22";
	$meuArray []= "23";
	$meuArray []= "24";
	$meuArray []= "25";
	$meuArray []= "26";
	$meuArray []= "29";
	$meuArray []= "30";
	$meuArray []= "31";
}
if($mes==2){
	$nomemes="Fevereiro";
	$meuArray []= "1";
	$meuArray []= "2";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "7";
	$meuArray []= "8";
	$meuArray []= "9";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "14";
	$meuArray []= "15";
	$meuArray []= "16";
	$meuArray []= "19";
	$meuArray []= "20";
	$meuArray []= "21";
	$meuArray []= "22";
	$meuArray []= "23";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "28";
}
if($mes==3){
	$nomemes="Março";
	$meuArray []= "1";
	$meuArray []= "2";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "7";
	$meuArray []= "8";
	$meuArray []= "9";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "14";
	$meuArray []= "15";
	$meuArray []= "16";
	$meuArray []= "19";
	$meuArray []= "20";
	$meuArray []= "21";
	$meuArray []= "22";
	$meuArray []= "23";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "28";
	$meuArray []= "29";
}
if($mes==4){
	$nomemes="Abril";
	$meuArray []= "2";
	$meuArray []= "3";
	$meuArray []= "4";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "9";
	$meuArray []= "10";
	$meuArray []= "11";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "16";
	$meuArray []= "17";
	$meuArray []= "18";
	$meuArray []= "19";
	$meuArray []= "20";
	$meuArray []= "23";
	$meuArray []= "24";
	$meuArray []= "25";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "30";
}
if($mes==5){
	$nomemes="Maio";
	$meuArray []= "2";
	$meuArray []= "3";
	$meuArray []= "4";
	$meuArray []= "7";
	$meuArray []= "8";
	$meuArray []= "9";
	$meuArray []= "10";
	$meuArray []= "11";
	$meuArray []= "14";
	$meuArray []= "15";
	$meuArray []= "16";
	$meuArray []= "17";
	$meuArray []= "18";
	$meuArray []= "21";
	$meuArray []= "22";
	$meuArray []= "23";
	$meuArray []= "24";
	$meuArray []= "25";
	$meuArray []= "28";
	$meuArray []= "29";
	$meuArray []= "30";
}
if($mes==6){
	$nomemes="Junho";
	$meuArray []= "1";
	$meuArray []= "4";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "7";
	$meuArray []= "8";
	$meuArray []= "11";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "14";
	$meuArray []= "15";
	$meuArray []= "18";
	$meuArray []= "19";
	$meuArray []= "20";
	$meuArray []= "21";
	$meuArray []= "22";
	$meuArray []= "25";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "28";
	$meuArray []= "29";
}
if($mes==7){
	$nomemes="Julho";
	$meuArray []= "2";
	$meuArray []= "3";
	$meuArray []= "4";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "9";
	$meuArray []= "10";
	$meuArray []= "11";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "16";
	$meuArray []= "17";
	$meuArray []= "18";
	$meuArray []= "19";
	$meuArray []= "20";
	$meuArray []= "23";
	$meuArray []= "24";
	$meuArray []= "25";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "30";
	$meuArray []= "31";
}
if($mes==8){
	$nomemes="Agosto";
	$meuArray []= "1";
	$meuArray []= "2";
	$meuArray []= "3";
	$meuArray []= "6";
	$meuArray []= "7";
	$meuArray []= "8";
	$meuArray []= "9";
	$meuArray []= "10";
	$meuArray []= "13";
	$meuArray []= "14";
	$meuArray []= "15";
	$meuArray []= "16";
	$meuArray []= "17";
	$meuArray []= "20";
	$meuArray []= "21";
	$meuArray []= "22";
	$meuArray []= "23";
	$meuArray []= "24";
	$meuArray []= "27";
	$meuArray []= "28";
	$meuArray []= "29";
	$meuArray []= "30";
	$meuArray []= "31";
}
if($mes==9){
	$nomemes="Setembro";
	$meuArray []= "3";
	$meuArray []= "4";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "10";
	$meuArray []= "11";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "14";
	$meuArray []= "17";
	$meuArray []= "18";
	$meuArray []= "19";
	$meuArray []= "21";
	$meuArray []= "24";
	$meuArray []= "25";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "28";
}
if($mes==10){
	$nomemes="Outubro";
	$meuArray []= "1";
	$meuArray []= "2";
	$meuArray []= "3";
	$meuArray []= "4";
	$meuArray []= "5";
	$meuArray []= "8";
	$meuArray []= "9";
	$meuArray []= "10";
	$meuArray []= "11";
	$meuArray []= "15";
	$meuArray []= "16";
	$meuArray []= "17";
	$meuArray []= "18";
	$meuArray []= "19";
	$meuArray []= "22";
	$meuArray []= "23";
	$meuArray []= "24";
	$meuArray []= "25";
	$meuArray []= "26";
	$meuArray []= "29";
	$meuArray []= "30";
	$meuArray []= "31";
}
if($mes==11){
	$nomemes="Novembro";
	$meuArray []= "1";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "7";
	$meuArray []= "8";
	$meuArray []= "9";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "14";
	$meuArray []= "16";
	$meuArray []= "19";
	$meuArray []= "20";
	$meuArray []= "21";
	$meuArray []= "22";
	$meuArray []= "23";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "28";
	$meuArray []= "29";
	$meuArray []= "30";
}
if($mes==12){
	$nomemes="Dezembro";
	$meuArray []= "3";
	$meuArray []= "4";
	$meuArray []= "5";
	$meuArray []= "6";
	$meuArray []= "7";
	$meuArray []= "10";
	$meuArray []= "11";
	$meuArray []= "12";
	$meuArray []= "13";
	$meuArray []= "14";
	$meuArray []= "17";
	$meuArray []= "18";
	$meuArray []= "19";
	$meuArray []= "20";
	$meuArray []= "21";
	$meuArray []= "24";
	$meuArray []= "26";
	$meuArray []= "27";
	$meuArray []= "28";
	$meuArray []= "31";
}
?>