<?php
// Inicia a sessão atual //
session_start();
// Destroi todos os dados da sessão (logout) // 
session_destroy();
header('Location: ../index.php');