<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
}

require_once '../conexao.php';

// Verifica se recebeu o ID do paciente
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Paciente não especificado.";
    exit;
}

$id = $_GET['id'];

// Busca dados do paciente
$stmt = $pdo->prepare("SELECT * FROM paciente WHERE id = ?");
$stmt->execute([$id]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$paciente) {
    echo "Paciente não encontrado.";
    exit;
}

// Atualiza dados se formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $tipo_sanguineo = $_POST['tipo_sanguineo'];
    $imagem_nome = $paciente['imagem']; // manter a imagem antiga por padrão

    // Verifica se nova imagem foi enviada
    if (!empty($_FILES['imagem']['name'])) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . '.' . $extensao;
        $caminho = __DIR__ . '/../storage/' . $imagem_nome;

        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho);
    }

    // Atualiza no banco
    $stmt = $pdo->prepare("UPDATE paciente SET nome = ?, cpf = ?, data_nascimento = ?, tipo_sanguineo = ?, imagem = ? WHERE id = ?");
    $stmt->execute([$nome, $cpf, $data_nascimento, $tipo_sanguineo, $imagem_nome, $id]);

    header("Location: index_paciente.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="../assets/css/editar_paciente.css">
</head>
<body>
    <div class="top-buttons">
        <a href="index_paciente.php"><button>Voltar</button></a>
    </div>

    <h1>Editar Paciente</h1>

    <form action="editar_paciente.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome completo:</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($paciente['nome']) ?>" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="<?= $paciente['cpf'] ?>" required>
        </div>

        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" value="<?= $paciente['data_nascimento'] ?>" required>
        </div>

        <div class="form-group">
            <label for="tipo_sanguineo">Tipo Sanguíneo:</label>
            <input type="text" name="tipo_sanguineo" id="tipo_sanguineo" value="<?= $paciente['tipo_sanguineo'] ?>" required>
        </div>

        <div class="form-group">
            <label for="imagem">Foto de Perfil:</label>
            <label for="imagem" class="custom-file-label">Escolher nova imagem</label>
            <input type="file" name="imagem" id="imagem" accept="image/*">
        </div>

        <!-- Prévia da imagem atual -->
        <div class="preview-container">
            <img id="preview" src="../storage/<?= $paciente['imagem'] ?>" alt="Imagem Atual">
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>

    <script>
        const inputFile = document.getElementById("imagem");
        const preview = document.getElementById("preview");

        inputFile.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>