<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
  }

require_once '../conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do paciente não informado.";
    exit;
  }

// Buscar os dados do paciente
$stmt = $pdo->prepare("SELECT * FROM paciente WHERE id = ?");
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    echo "Paciente não encontrado.";
    exit;
  }
  
// Atualizar os dados se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];

    $stmt = $pdo->prepare("UPDATE paciente SET nome = ?, cpf = ?, data_nascimento = ?, tipo_sanguineo = ? WHERE id = ?");
    $stmt->execute([$nome, $cpf, $data_nascimento, $tipo_sanguineo, $id]);

    header("Location: index_paciente.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
</head>
<body>
    <h1>Editar Paciente</h1>
    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($paciente['nome']) ?>" required><br><br>

        <label>CPF:</label><br>
        <input type="text" name="cpf" value="<?= htmlspecialchars($paciente['cpf']) ?>" required><br><br>

        <label>Data de Nascimento:</label><br>
        <input type="date" name="data_nascimento" value="<?= $paciente['data_nascimento'] ?>" required><br><br>

        <label>Tipo Sanguíneo:</label><br>
        <input type="text" name="tipo_sanguineo" value="<?= htmlspecialchars($paciente['tipo_sanguineo']) ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>