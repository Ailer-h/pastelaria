<?php
    include "utilities/checkSession.php";
    include "utilities/checkPermissions.php";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaFuncionarios.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Funcionários</title>
</head>
<body>
        
<div class="navbar">
        <a href="adm_dashboard.php">
        <div class="logo"></div>
        </a>

        <h1>Funcionários</h1>
        <div class="menu">
            <button>Produtos</button>
            <button>Pedidos</button>
            
            <div class="user-area">
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";

                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"><p>Logout</p></div></a>
            </div>
        </div>
    </div>

    <div class="center">
        <div class="table-header">
        
            <form action="tabelaEstoque.php" method="post" id="searchbox">
                <input type="text" placeholder="Pesquisar..." name="search" id="searchbar">
                <input type="submit" value="🔎︎">
                <a href="tabelaEstoque.php"><img src="../images/icons/close.png" id="close-search"></a>
            </form>

            <div id="menu">
                <button onclick=""><img src="../images/icons/report.png"></button>
                <button onclick="setForm(0)"><img src="../images/icons/plus.png"></button>
            </div>

        </div>
       
        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;"><th style="border-left: none;">Nome</th><th>D. Vencimento</th><th>Custo (R$)</th><th>Qtd</th><th>Status</th><th style="border-right: none;">Ações</th></tr>

            </table>
        </div>
    </div>

    <div id="form-box">
    </div>

</body>
<script src="../js/handleForms_estoque.js"></script>
</html>