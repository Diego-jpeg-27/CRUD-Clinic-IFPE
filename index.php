<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - CRUD Clinic IFPE</title>
</head>
<body>

<h2>Login</h2>
<form action="auth/login.php" method="POST">
  <label for="usuario">Usuário:</label><br>
  <input type="text" name="usuario" required><br><br>

  <label for="senha">Senha:</label><br>
  <input type="password" name="senha" required><br><br>

  <input type="submit" value="Entrar">
</form>

</body>
</html>
  