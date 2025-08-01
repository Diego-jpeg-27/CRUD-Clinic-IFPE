<?php
require_once("../conexao.php");

if (!isset($_GET['id'])) {
    echo "ID da consulta não informado.";
    exit();
 }

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM consulta WHERE id = :id");
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: index_consulta.php");
exit();
?>