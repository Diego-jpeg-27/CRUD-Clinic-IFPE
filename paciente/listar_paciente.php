<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
}

require_once '../conexao.php';

$id = $_GET['id'] ?? null;

// Busca o paciente pelo ID
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM paciente WHERE id = ?");
    $stmt->execute([$id]);
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $paciente = false;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Paciente</title>
</head>
<body>
    <h1>Detalhes do Paciente</h1>

    <nav>
        <a href="../painel.php">Voltar ao Painel</a> |
        <a href="cadastrar_paciente.php">Novo Paciente</a>
    </nav>

    <main>
        <?php if ($paciente): ?>
            <p><strong>ID:</strong> <?= $paciente['id'] ?></p>
            <p><strong>Nome:</strong> <?= $paciente['nome'] ?></p>
            <p><strong>CPF:</strong> <?= $paciente['cpf'] ?></p>
            <p><strong>Data de Nascimento:</strong> <?= $paciente['data_nascimento'] ?></p>
            <p><strong>Tipo Sanguíneo:</strong> <?= $paciente['tipo_sanguineo'] ?></p>
            <p>
                <a href="editar_paciente.php?id=<?= $paciente['id'] ?>">Editar</a> |
                <a href="excluir_paciente.php?id=<?= $paciente['id'] ?>">Excluir</a>
            </p>
        <?php else: ?>
            <p>Paciente não encontrado.</p>
        <?php endif; ?>
    </main>
</body>
</html>
