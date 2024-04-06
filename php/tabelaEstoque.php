<?php
    include "utilities/checkSession.php"
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaEstoque.css">
    <title>Estoque</title>
</head>
<body>
    
    <div class="navbar">
        <div class="logo"></div>
        <h1>Estoque</h1>
        <div class="menu">
            <a href="adm_dashboard.php"><button>Pagina Inicial</button></a>
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
            </form>

            <form action="tabelaEstoque.php" method="post" id="filter">
                <input type="date" name="start-date" id="start-date">
                <input type="date" name="end-date" id="end-date">
                <input type="submit" value="Filtrar">
                <button><img src="../images/icons/plus.png"></button>
            </form>

        </div>
       
        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                    <th>Nome</th>
                    <th>D. Vencimento</th>
                    <th>Custo (R$)</th>
                    <th>Uni. Medida</th>
                    <th>Qtd</th>
                    <th></th>
                    <th></th>
                </tr>



            </table>
        </div>
    </div>
    
</body>
</html>