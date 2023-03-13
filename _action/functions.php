<?php 

class Crud {
	private $pdo;

	public function __construct() {
		$this->connect();
	}

	private function connect() {
		require_once 'conecta/config.php';

		$dsn = "mysql:host=$host;dbname=$db;";
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		try {
			$this->pdo = new PDO($dsn, $user, $pass, $options);
		} catch(PDOException $e) {
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	} 

	public function create($table, $data) {
		$keys = implode(',', array_keys($data));
		$values = ':' . implode(',:', array_keys($data));
		$sql = "INSERT INTO $table ($keys) VALUES ($values)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($data);
		return $this->pdo->lastInsertId();
	}

	public function read($table, $id, $name_id) {
		$sql = "SELECT * FROM $table WHERE $name_id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function update($table, $id, $data) {
		$set = '';
		foreach ($data as $key => $value) {
			$set .= "$key = :$key,";
		}
		$set = rtrim($set, ',');
		$sql = "UPDATE $table SET $set WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute($data);
		return $stmt->rowCount();
	}

	public function delete($table, $id) {
		$sql = "DELETE FROM $table WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function verificarFaltas($id_assist) {
		$falta = 0;
		$sql = "SELECT * FROM atendimentos WHERE id_assist = :id_assist AND estado = 'Falta' AND data < CURDATE() ORDER BY data DESC LIMIT 5";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(":id_assist", $id_assist, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($result as $row) {
			$row['estado'] == "Falta" ? $falta++ : null;
		}

		return $falta;
	}

	public function pegarHistoricoAtendimentos($id_assistido) {
    $sql = "SELECT atendimentos.*, servicos.nome as servico_nome, profissionais.nome as profissional_nome
            FROM atendimentos
            INNER JOIN servicos ON atendimentos.id_serv = servicos.id
            INNER JOIN profissionais ON atendimentos.id_prof = profissionais.id
            WHERE atendimentos.id_assist = :id_assistido
            ORDER BY atendimentos.id DESC LIMIT 10";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(":id_assistido", $id_assistido, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $result;
}

}


?>