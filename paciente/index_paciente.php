<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
}

require_once '../conexao.php';

// Busca todos os pacientes do banco
$stmt = $pdo->query("SELECT * FROM paciente ORDER BY id DESC");
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="../assets/css/index_paciente.css">
</head>
<body>
    <!-- Botão no canto superior esquerdo -->
    <div class="top-left">
        <a href="../painel.php" class="button">Voltar</a>
    </div>

    <h1>Pacientes Cadastrados</h1>

    <!-- Botão centralizado abaixo do título -->
    <div class="novo-paciente">
        <a href="cadastrar_paciente.php" class="button">Novo Paciente</a>
    </div>

<?php if (count($pacientes) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Identificador</th>
                <th>Nome Completo</th>
                <th>CPF</th>
                <th>Tipo Sanguíneo</th>
                <th>Data de Nascimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pacientes as $paciente): ?>
                <tr>
                    <td><?= $paciente['id'] ?></td>
                    <td><?= htmlspecialchars($paciente['nome']) ?></td>
                    <td><?= $paciente['cpf'] ?></td>
                    <td><?= $paciente['tipo_sanguineo'] ?></td>
                    <td><?= date('d/m/Y', strtotime($paciente['data_nascimento'])) ?></td>
                    <td>
                        <a href="editar_paciente.php?id=<?= $paciente['id'] ?>">Editar</a> |
                        <a href="excluir_paciente.php?id=<?= $paciente['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este paciente?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum paciente cadastrado ainda.</p>
<?php endif; ?>
</body>
</html>