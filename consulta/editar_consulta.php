<?php
require_once("../conexao.php");

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
    echo "ID da consulta não informado.";
    exit();
 }

$id = $_GET['id'];

// Buscar dados da consulta
$stmt = $pdo->prepare("SELECT * FROM consulta WHERE id = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();
$consulta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$consulta) {
    echo "Consulta não encontrada.";
    exit();
 }

// Buscar pacientes e médicos para os <select>
$pacientes = $pdo->query("SELECT id, nome FROM paciente ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$medicos = $pdo->query("SELECT id, nome FROM medico ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Atualiza consulta
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_paciente = $_POST["id_paciente"];
    $id_medico = $_POST["id_medico"];
    $data_hora_raw = $_POST["data_hora"];
    $observacoes = $_POST["observacoes"];

    $data_hora = date('Y-m-d H:i:s', strtotime($data_hora_raw));

    $stmt = $pdo->prepare("UPDATE consulta SET id_paciente = :id_paciente, id_medico = :id_medico, data_hora = :data_hora, observacoes = :observacoes WHERE id = :id");
    $stmt->bindParam(":id_paciente", $id_paciente);
    $stmt->bindParam(":id_medico", $id_medico);
    $stmt->bindParam(":data_hora", $data_hora);
    $stmt->bindParam(":observacoes", $observacoes);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location: index_consulta.php");
    exit();
 }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Consulta</title>
    <link rel="stylesheet" href="../assets/css/registrar_consulta.css">
</head>
<body>
<div class="top-buttons">
    <a href="index_consulta.php"><button>Voltar</button></a>
</div>

<h1>Editar Consulta</h1>
<form method="POST">
    <div class="form-group">
        <label for="id_paciente">Paciente:</label>
        <select name="id_paciente" required>
            <?php foreach ($pacientes as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id'] == $consulta['id_paciente'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_medico">Médico:</label>
        <select name="id_medico" required>
            <?php foreach ($medicos as $m): ?>
                <option value="<?= $m['id'] ?>" <?= $m['id'] == $consulta['id_medico'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="data_hora">Data e Hora da Consulta:</label>
        <input type="datetime-local" name="data_hora" value="<?= date('Y-m-d\TH:i', strtotime($consulta['data_hora'])) ?>" required>
    </div>

    <div class="form-group">
        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" rows="4"><?= htmlspecialchars($consulta['observacoes']) ?></textarea>
    </div>

    <button type="submit">Salvar Alterações</button>
  </form>
 </body>
</html>