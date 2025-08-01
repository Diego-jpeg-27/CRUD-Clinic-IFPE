<?php
session_start();
require_once("../conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $senha = $_POST["senha"];

    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nome = :nome");
    $stmt->bindParam(":nome", $usuario);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senha, $user["senha"])) {
            $_SESSION["logado"] = true;
            $_SESSION["usuario"] = $user["nome"];
            header("Location: ../painel.php");
            exit;
        }
    }

    // Se chegou aqui, deu errado
    $erro = "Usuário ou senha inválidos.";
 }
?>