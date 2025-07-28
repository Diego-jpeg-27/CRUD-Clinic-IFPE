<?php
// Dados da conexão
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "crud_clinic";

// Conexão com o banco de dados
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
