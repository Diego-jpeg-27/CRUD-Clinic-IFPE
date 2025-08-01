<?php
// verificações de sessão, proteção do arquivo.
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
 }
 
require_once("../conexao.php");

// Buscar pacientes
$stmtPacientes = $pdo->query("SELECT id, nome FROM paciente ORDER BY nome");
$pacientes = $stmtPacientes->fetchAll(PDO::FETCH_ASSOC);

// Buscar médicos
$stmtMedicos = $pdo->query("SELECT id, nome FROM medico ORDER BY nome");
$medicos = $stmtMedicos->fetchAll(PDO::FETCH_ASSOC);

// Verifica se formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_paciente = $_POST["id_paciente"];
    $id_medico = $_POST["id_medico"];
    $data_hora_raw = $_POST["data_hora"];
    $observacoes = $_POST["observacoes"];

    // Formata para o padrão aceito pelo MySQL
    $data_hora = date('Y-m-d H:i:s', strtotime($data_hora_raw));

    try {
        $stmt = $pdo->prepare("INSERT INTO consulta (id_paciente, id_medico, data_hora, observacoes) 
                               VALUES (:id_paciente, :id_medico, :data_hora, :observacoes)");
        $stmt->bindParam(":id_paciente", $id_paciente);
        $stmt->bindParam(":id_medico", $id_medico);
        $stmt->bindParam(":data_hora", $data_hora);
        $stmt->bindParam(":observacoes", $observacoes);
        $stmt->execute();

        header("Location: index_consulta.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao registrar consulta: " . $e->getMessage();
    }
 }
?>

<!DOCTYPE html>
<html lang="pt-BR">
 <head>
    <meta charset="UTF-8">
    <title>Registrar Consulta</title>
    <link rel="stylesheet" href="../assets/css/registrar_consulta.css">
 </head>
  <body>

<div class="top-buttons">
    <a href="../painel.php"><button>Voltar</button></a>
</div>

<h1>Registrar Nova Consulta</h1>

<form method="POST">
    <div class="form-group">
        <label for="id_paciente">Paciente:</label>
        <select name="id_paciente" id="id_paciente" required>
            <option value="">Selecione um paciente</option>
            <?php foreach ($pacientes as $paciente): ?>
                <option value="<?= $paciente['id'] ?>"><?= htmlspecialchars($paciente['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_medico">Médico:</label>
        <select name="id_medico" id="id_medico" required>
            <option value="">Selecione um médico</option>
            <?php foreach ($medicos as $medico): ?>
                <option value="<?= $medico['id'] ?>"><?= htmlspecialchars($medico['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="data_hora">Data e Hora da Consulta:</label>
        <input type="datetime-local" name="data_hora" id="data_hora" required>
    </div>

    <div class="form-group">
        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" id="observacoes" rows="4" placeholder="Escreva algo relevante (opcional)"></textarea>
    </div>

    <button type="submit">Registrar Consulta</button>
</form>

  </body>
</html>
