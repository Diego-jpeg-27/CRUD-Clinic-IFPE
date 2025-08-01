<?php
// verificações de sessão, proteção do arquivo.
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
}

require_once("../conexao.php");

// Habilita erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET["id"])) {
    echo "ID do médico não especificado.";
    exit();
}

$id = $_GET["id"];
$medico = null;

// Buscar dados do médico
try {
    $sql = "SELECT * FROM medico WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $medico = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$medico) {
        echo "Médico não encontrado.";
        exit();
    }
} catch (PDOException $e) {
    echo "Erro ao buscar médico: " . $e->getMessage();
    exit();
}

// Atualizar dados do médico
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $crm = $_POST["crm"];
    $especialidade = $_POST["especialidade"];

    try {
        $sql = "UPDATE medico SET nome = :nome, crm = :crm, especialidade = :especialidade WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":crm", $crm);
        $stmt->bindParam(":especialidade", $especialidade);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        header("Location: index_medico.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar médico: " . $e->getMessage();
    }
 }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Médico</title>
    <link rel="stylesheet" href="../assets/css/cadastrar_medico.css">
</head>
<body>

<div class="top-buttons">
    <a href="../painel.php"><button>Voltar</button></a>
</div>

<h1>Editar Médico</h1>

<form method="POST">
    <div class="form-group">
        <label for="nome">Nome completo:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($medico["nome"]) ?>" required>
    </div>

    <div class="form-group">
        <label for="crm">CRM:</label>
        <input type="text" id="crm" name="crm" value="<?= htmlspecialchars($medico["crm"]) ?>" required>
    </div>

    <div class="form-group">
        <label for="especialidade">Especialidade:</label>
        <input type="text" id="especialidade" name="especialidade" value="<?= htmlspecialchars($medico["especialidade"]) ?>" required>
    </div>

    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>