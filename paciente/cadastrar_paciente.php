 <?php
 session_start();
  if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
   header('Location: ../index.php');
  exit;
}

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];

    $stmt = $pdo->prepare("INSERT INTO paciente (nome, cpf, data_nascimento, tipo_sanguineo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $cpf, $data_nascimento, $tipo_sanguineo]);

    header('Location: index_paciente.php');
    exit;
 }

?>
<!DOCTYPE html>
 <html lang="pt-BR">
  <head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="../assets/css/cadastrar_paciente.css">
   <title>Cadastrar Paciente</title>
  </head>

  <body>
   <div class="top-buttons">
   <a href="../painel.php"><button>Voltar</button></a>
   </div>

    <h1>Cadastrar Paciente</h1>
    
    <form action="cadastrar_paciente.php" method="POST">
    <div class="form-group">
        <label for="nome">Nome completo:</label>
        <input type="text" name="nome" id="nome" required>
    </div>

    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" placeholder="000.000.000-00" required>
    </div>

    <div class="form-group">
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" required>
    </div>

    <div class="form-group">
        <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
        <input type="text" name="tipo_sanguineo" id="tipo_sanguineo" placeholder="Ex: O+, A-, AB+" required>
    </div>

     <button type="submit">Cadastrar</button>
    </form>
   </body>
</html>