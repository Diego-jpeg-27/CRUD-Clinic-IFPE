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
    $imagem_nome = null;

    // Verifica se foi enviado um arquivo de imagem
    if (!empty($_FILES['imagem']['name'])) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . '.' . $extensao;
        $caminho = __DIR__ . '/../storage/' . $imagem_nome;

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
    }

    $stmt = $pdo->prepare("INSERT INTO paciente (nome, cpf, data_nascimento, tipo_sanguineo, imagem) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $cpf, $data_nascimento, $tipo_sanguineo, $imagem_nome]);

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
    <!-- Botão Voltar -->
    <div class="top-buttons">
        <a href="../painel.php"><button>Voltar</button></a>
    </div>

    <!-- Preview da imagem no canto superior direito -->
    <div class="preview-container">
        <img id="preview" src="#" alt="Prévia da Imagem" style="display: none;">
    </div>

    <!-- Título -->
    <h1>Cadastrar Paciente</h1>

    <!-- Formulário -->
    <form action="cadastrar_paciente.php" method="POST" enctype="multipart/form-data">
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

        <div class="form-group">
            <label for="imagem">Foto de Perfil:</label>
            <label for="imagem" class="custom-file-label">Escolher imagem</label>
            <input type="file" name="imagem" id="imagem" accept="image/*">
        </div>

        <button type="submit">Cadastrar</button>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputFile = document.getElementById("imagem");
            const preview = document.getElementById("preview");

            inputFile.addEventListener("change", function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
 </body>
</html>