<?php
include_once("../conexao.php");

try {
    $sql = "SELECT * FROM medico";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar médicos: " . $e->getMessage();
    exit();
 }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Médicos</title>
    <link rel="stylesheet" href="../assets/css/index_medico.css">
</head>
 <body>

    <div class="top-buttons">
        <a href="../painel.php"><button>Voltar</button></a>
    </div>

    <h1>Médicos Cadastrados</h1>

    <a href="cadastrar_medico.php"><button>Novo Médico</button></a>

    <table>
        <thead>
            <tr>
                <th>Identificador</th>
                <th>Nome</th>
                <th>CRM</th>
                <th>Especialidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicos as $medico): ?>
                <tr>
                    <td><?= htmlspecialchars($medico["id"]) ?></td>
                    <td><?= htmlspecialchars($medico["nome"]) ?></td>
                    <td><?= htmlspecialchars($medico["crm"]) ?></td>
                    <td><?= htmlspecialchars($medico["especialidade"]) ?></td>
                    <td>
                        <a href="ver_medico.php?id=<?= $medico["id"] ?>">Ver</a> |
                        <a href="editar_medico.php?id=<?= $medico["id"] ?>">Editar</a> |
                        <a href="excluir_medico.php?id=<?= $medico["id"] ?>" onclick="return confirm('Tem certeza que deseja excluir este médico?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

 </body>
</html>