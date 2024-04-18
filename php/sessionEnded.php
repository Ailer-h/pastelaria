<?php

    //Finaliza a sessão do usuário
    session_start();

    session_destroy();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/warningPages.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Sessão Encerrada</title>
</head>
<body>
    
    <div class="center">
        <img src="../images/icons/logoff.png">
        <h1>Sua sessão foi encerrada!</h1>
        <a href="login.php"><button>Fazer Login</button></a>
    </div>

</body>
</html>