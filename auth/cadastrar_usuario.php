<?php
session_start();
require_once("../conexao.php");

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["usuario"]);
    $senha = $_POST["senha"];
    $senha_repetida = $_POST["senha_repetida"];

    // Verifica se as senhas são iguais
    if ($senha !== $senha_repetida) {
        $erro = "As senhas são diferentes!";
    } else {
        // Verifica se já existe o usuário
        $stmt = $pdo->prepare("SELECT id FROM usuario WHERE nome = :nome");
        $stmt->bindParam(":nome", $nome);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $erro = "Usuário já existe!";
        } else {
            // Criptografa a senha
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            // Insere no banco
            $stmt = $pdo->prepare("INSERT INTO usuario (nome, senha) VALUES (:nome, :senha)");
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":senha", $senhaCriptografada);
            $stmt->execute();

            // Redireciona para login
            header("Location: ../index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../assets/css/cadastrar_usuario.css">
</head>
<body>

<div class="container">

    <?php if (isset($erro)): ?>
        <p class="erro-msg"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <h2>Cadastrar Novo Usuário</h2>

        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <label for="senha_repetida">Repetir Senha:</label>
        <input type="password" name="senha_repetida" required>

        <input type="submit" value="Cadastrar">
    </form>

    <a class="voltar-link" href="../index.php">Fazer Login</a>
    </div>
 </body>
</html>