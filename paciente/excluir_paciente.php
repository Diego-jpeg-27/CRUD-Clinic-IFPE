<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../index.php');
    exit;
  }

require_once '../conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID do paciente não informado.";
    exit;
  }

// Executa a exclusão
$stmt = $pdo->prepare("DELETE FROM paciente WHERE id = ?");
$stmt->execute([$id]);

header("Location: index_paciente.php");
exit;