<?php
// verificações de sessão, proteção do arquivo.
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
 }

require_once '../conexao.php';

if (!isset($_GET["id"])) {
    echo "ID do médico não especificado.";
    exit();
 }

$id = $_GET["id"];

try {
    $stmt = $pdo->prepare("DELETE FROM medico WHERE id = :id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("Location: index_medico.php");
    exit();
} catch (PDOException $e) {
    echo "Erro ao excluir médico: " . $e->getMessage();
    exit();
 }
?>