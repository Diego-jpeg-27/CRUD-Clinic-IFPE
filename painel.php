<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: index.php'); 
    exit;
 }
?>

<!DOCTYPE html>
<html lang="pt-br">
 <head>
  <meta charset="UTF-8">
  <title>Painel - CRUD Clinic IFPE</title>
  <link rel="stylesheet" href="assets/css/painel.css">
 </head>
<body>

<!-- Botões canto esquerdo e direito -->
<div class="top-buttons">
  <a href="index.php"><button>Voltar</button></a>
  <a href="auth/logout.php"><button>Sair</button></a>
</div>

<div class="container">
  <h1>Painel Principal</h1>

  <div class="grid">
    <a href="consulta/registrar_consulta.php"><button>Registrar Consulta</button></a>
    <a href="consulta/index_consulta.php"><button>Ver Consulta</button></a>

    <a href="paciente/cadastrar_paciente.php"><button>Cadastrar Paciente</button></a>
    <a href="paciente/index_paciente.php"><button>Ver Pacientes</button></a>


    <a href="medico/cadastrar_medico.php"><button>Cadastrar Médico</button></a>
    <a href="medico/index_medico.php"><button>Ver Médicos</button></a>
  </div>
  </div>

 </body>
</html>