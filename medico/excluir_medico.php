<?php
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