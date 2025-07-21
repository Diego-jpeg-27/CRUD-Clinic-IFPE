<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: index.php'); // Redireciona para login
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel - CRUD Clinic IFPE</title>
</head>
<body>

<h2>Painel Principal</h2>

<a href="consulta/registrar.php"><button>Registrar Consulta</button></a><br><br>
<a href="paciente/cadastrar.php"><button>Cadastrar Paciente</button></a><br><br>
<a href="medico/cadastrar.php"><button>Cadastrar Médico</button></a><br><br>
<a href="auth/logout.php"><button>Sair</button></a>

<a href="index.php"><button>Voltar</button></a><br><br>
</body>
</html>
