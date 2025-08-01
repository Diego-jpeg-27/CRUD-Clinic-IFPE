<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: listar_medico.php");
    exit();
 }

require_once '../conexao.php';

// Buscar médicos
$stmt = $pdo->query("SELECT * FROM medico ORDER BY id DESC");
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Médicos</title>
    <link rel="stylesheet" href="../assets/css/index_medico.css">
</head>
 <body>

<!-- Botão Voltar no canto superior esquerdo -->
<div class="top-buttons">
    <a href="../painel.php"><button>Voltar</button></a>
</div>

<h1>Médicos Cadastrados</h1>

<!-- Botão cadastrar médico abaixo do título -->
<div class="action-buttons">
    <a href="cadastrar_medico.php"><button>Cadastrar Médico</button></a>
</div>

<?php if (count($medicos) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Especialidade</th>
                <th>CRM</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicos as $medico): ?>
                <tr>
                    <td><?= $medico['id'] ?></td>
                    <td><?= htmlspecialchars($medico['nome']) ?></td>
                    <td><?= htmlspecialchars($medico['especialidade']) ?></td>
                    <td><?= htmlspecialchars($medico['crm']) ?></td>
                    <td>
                        <a href="editar_medico.php?id=<?= $medico['id'] ?>">Editar</a> |
                        <a href="excluir_medico.php?id=<?= $medico['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum médico cadastrado ainda.</p>
<?php endif; ?>

 </body>
</html>