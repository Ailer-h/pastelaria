<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pdv.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Novo Pedido</title>
</head>
<body>

    <div class="navbar">
        <?php
            
            if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                echo"<a href='adm_dashboard.php'>
                        <div class='logo'></div>
                    </a>";
            
            }else{
                echo"<div class='logo'></div>";
            }
        
        ?>

        <h1>Novo Pedido</h1>
        
        <div class="menu">

        <?php
        
            if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                echo"<a href='tabelaProdutos.php'><button>Produtos</button></a>
                    <button>Pedidos</button>";
            }
        
        ?>

            <div class="user-area">
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";

                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"><p>Logout</p></div></a>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="left">
            <div class="order-header"><h1>Pedido</h1></div>
            <div class="order-list">
                <div class="info-cliente">
                    <h3>Informações do Cliente</h3>
                    <div>
                        <label for="nome_cli">Nome:</label>
                        <input type="text" name="nome_cli" id="nome_cli">
                    </div>
                    <div>
                        <label for="telefone_cli">Telefone:</label>
                        <input type="text" name="telefone_cli" id="telefone_cli">
                    </div>
                </div>
                <div class="pedido">
                    <table>
                        <tr style="position: sticky; top: 0;">
                            <th style="border-left: none;">Nome:</th>
                            <th>Qtd:</th>
                            <th>Preço</th>
                            <th style="border-right: none; width: 3em;"></th>
                        </tr>

                        <tr class="normal-row">
                            <td>Comida</td>
                            <td>2</td>
                            <td>R$220.54</td>
                            <td><img src="../images/icons/minus.png" alt="Remover"></td>
                        </tr>
                    </table>
                </div>
                <hr>
                <div class="confirmar">
                    <input type="submit" name="confirmar" id="confirmar" value="Confirmar">
                </div>
            
            </div>
        </div>

        <div class="right">
            <div class="menu-header"><h1>Menu</h1></div>
            <div class="menu"></div>
        </div>
    </div>

</body>
</html>