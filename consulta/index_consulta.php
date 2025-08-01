<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../conexao.php");

$stmt = $pdo->query("
    SELECT c.id, c.data_hora, c.observacoes,
           p.nome AS nome_paciente,
           m.nome AS nome_medico
    FROM consulta c
    JOIN paciente p ON c.id_paciente = p.id
    JOIN medico m ON c.id_medico = m.id
    ORDER BY c.data_hora DESC
");
$consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Consultas Agendadas</title>
    <link rel="stylesheet" href="../assets/css/index_consultar.css">
</head>
 <body>

<div class="top-left">
    <a href="../painel.php"><button>Voltar</button></a>
</div>

<h1>Consultas Agendadas</h1>

<div class="novo-consulta">
    <a href="registrar_consulta.php"><button>Nova Consulta</button></a>
</div>

<?php if (count($consultas) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Data e Hora</th>
                <th>Observações</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?= $consulta['id'] ?></td>
                    <td><?= htmlspecialchars($consulta['nome_paciente']) ?></td>
                    <td><?= htmlspecialchars($consulta['nome_medico']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($consulta['data_hora'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($consulta['observacoes'])) ?></td>
                    <td>
                        <a href="editar_consulta.php?id=<?= $consulta['id'] ?>">Editar</a> |
                        <a href="excluir_consulta.php?id=<?= $consulta['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  <?php else: ?>
    <p>Nenhuma consulta agendada.</p>
  <?php endif; ?>

 </body>
</html>