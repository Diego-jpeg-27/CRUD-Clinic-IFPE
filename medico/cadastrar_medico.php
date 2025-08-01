<?php
require_once '../conexao.php';

$nome = $crm = $especialidade = "";
$editando = false;

// Verifica se está editando
if (isset($_GET['id'])) {
    $editando = true;
    $id = $_GET['id'];

    // Buscar dados antigos
    $stmt = $pdo->prepare("SELECT * FROM medico WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $medico = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($medico) {
        $nome = $medico['nome'];
        $crm = $medico['crm'];
        $especialidade = $medico['especialidade'];
    } else {
        echo "Médico não encontrado.";
        exit();
    }
  }

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $crm = $_POST["crm"];
    $especialidade = $_POST["especialidade"];

    try {
        if ($editando) {
            $stmt = $pdo->prepare("UPDATE medico SET nome = :nome, crm = :crm, especialidade = :especialidade WHERE id = :id");
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":crm", $crm);
            $stmt->bindParam(":especialidade", $especialidade);
            $stmt->bindParam(":id", $id);
        } else {
            $stmt = $pdo->prepare("INSERT INTO medico (nome, crm, especialidade) VALUES (:nome, :crm, :especialidade)");
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":crm", $crm);
            $stmt->bindParam(":especialidade", $especialidade);
        }

        $stmt->execute();
        header("Location: index_medico.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao salvar médico: " . $e->getMessage();
    }
  }
?>
<!DOCTYPE html>
 <html lang="pt-BR">
 <head>
    <meta charset="UTF-8">
    <title><?= $editando ? "Editar Médico" : "Cadastrar Médico" ?></title>
    <link rel="stylesheet" href="../assets/css/cadastrar_medico.css">
 </head>
<body>

    <div class="top-buttons">
        <a href="../painel.php"><button>Voltar</button></a>
    </div>

    <h1><?= $editando ? "Editar Médico" : "Cadastrar Médico" ?></h1>

    <form method="POST">
        <div class="form-group">
            <label for="nome">Nome completo:</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($nome) ?>" required>
        </div>

        <div class="form-group">
            <label for="crm">CRM:</label>
            <input type="text" name="crm" id="crm" value="<?= htmlspecialchars($crm) ?>" placeholder="Ex: 123456-PE" required>
        </div>

        <div class="form-group">
            <label for="especialidade">Especialidade:</label>
            <input type="text" name="especialidade" id="especialidade" value="<?= htmlspecialchars($especialidade) ?>" placeholder="Ex: Pediatria, Ortopedia" required>
        </div>

        <button type="submit"><?= $editando ? "Salvar Alterações" : "Cadastrar" ?></button>
    </form>

 </body>
</html>