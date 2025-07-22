<?php
session_start();
include '../conexao.php'; 

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Simples verificação ( true or false )
if ($usuario === 'admin' && $senha === '123') {
    $_SESSION['logado'] = true;
    header('Location: ../painel.php');
    exit;
} else {
    echo "Usuário ou senha inválidos.";
}
