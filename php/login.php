<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="center">
        <form action="checkUser.php" method="post">
            <div class="form-login">
                <h1>Login</h1>
                <label for="user">Código de Login:</label>
                <input type="text" id="user" name="user" required>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>

                <input type="submit" value="Entrar">
            </div>
        </form>
    </div>
</body>

</html>