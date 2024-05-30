<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/relatorios.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Document</title>
</head>
<body>
<div class="navbar">
        <a href="adm_dashboard.php">
        <div class="logo"></div>
        </a>

        <h1>Clientes</h1>
        <div class="menu">
            <a href="tabelaFornecedores.php"><button>Fornecedores</button></a>
            <a href="tabelaFuncionarios.php"><button>Funcionários</button></a>

            <div class="user-area">
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";

                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"><p>Logout</p></div></a>
            </div>
        </div>
    </div>
</body>
</html>