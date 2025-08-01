<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - CRUD Clinic IFPE</title>
  <link rel="stylesheet" href="assets/css/index.css">
</head>
 <body>

  <form action="auth/login.php" method="POST">
    <label for="usuario">Usuário:</label><br>
    <input type="text" name="usuario" required>

    <label for="senha">Senha:</label><br>
    <input type="password" name="senha" required>

    <input type="submit" value="Entrar">

    <a href="auth/cadastrar_usuario.php" class="botao-link">Cadastre-se</a>
  </form>
 </body>
</html>