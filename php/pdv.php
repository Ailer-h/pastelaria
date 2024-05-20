<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    function fixMoney($value){
        return str_replace(".", ",", sprintf("%1$.2f", $value));
    }

    //Função que recebe o id do produto desejado e checa se tem ingredientes para faze-lo
    function hasIngredients($id){
        
        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select ig.id_ingrediente, (est.qtd - ig.qtd_ingrediente) from ingredientes_prod ig, estoque est where ig.id_produto = $id and ig.id_ingrediente = est.id_item;");

        while($out = mysqli_fetch_array($query)){
            if($out[1] < 0){ return false; }
        }

        return true;
    }

    //Função que recebe o id do produto desejado e retorna o maximo de pedidos que podem ser feitos
    function getMaxOrders($id){

        include "utilities/mysql_connect.php";
    
        $max = mysqli_fetch_array(mysqli_query($connection, "select (est.qtd / ig.qtd_ingrediente) from ingredientes_prod ig, estoque est where ig.id_produto = $id and ig.id_ingrediente = est.id_item order by (est.qtd / ig.qtd_ingrediente) asc;"))[0];
    
        return floor($max);
    }

    function showMenu(){
        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_prod, nome_prod, img_prod, valor_venda from produtos;");

        while($output = mysqli_fetch_array($query)){

            $price = fixMoney($output[3]);
            // echo"<script>console.log('$output[3]')</script>";
            $max = getMaxOrders($output[0]);

            if(hasIngredients($output[0])){

                echo"<div><div class='item'><div class='prod'>";
                
                echo"<img src='data:image;base64,$output[2]'>";
                echo"<p>$output[1] - R$$price</p>";
                echo"<button class='button' type='button' id='btn$output[0]' onclick='getOrders($output[0])'>Adicionar</button>";
                echo"<input type='number' max='$max' value='0' name='qtd$output[0]' id='qtd$output[0]' style='display: none;'>";
                
                echo"</div></div></div>";
            }else{

                echo"<div><div class='item'><div class='prod'>";
                
                echo"<img src='data:image;base64,$output[2]'>";
                echo"<p>$output[1] - R$$price</p>";
                echo"<button class='disabled-btn' type='button' disabled>Adicionar</button>";
                echo"<input type='number' name='qtd$output[0]' id='qtd$output[0]' style='display: none;' disabled>";
                
                echo"</div></div></div>";

            }

        }

        mysqli_close($connection);

    }

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

    <form action="pdv.php" method="post">
    <div class="grid">
        <div class="left">
            <div class="order-header"><h1>Pedido</h1></div>
            <div class="order-list">
                <div class="info-cliente">
                    <h3>Informações do Cliente</h3>
                    <div class="fields">
                        <label for="nome_cli">Nome:</label>
                        <input type="text" name="nome_cli" id="nome_cli">
                    </div>
                    <div class="fields">
                        <label for="telefone_cli">Telefone:</label>
                        <input type="text" name="telefone_cli" id="telefone_cli">
                    </div>
                    <div class="fields">
                        <label for="endereco_cli">Endereço:</label>
                        <input type="text" name="endereco_cli" id="endereco_cli">
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
            <div class="menu">
                <div class="prod-grid">
                    <?php showMenu(); ?>
                </div>
            </div>
        </div>
    </div>
    </form>

</body>
<script src="../js/masks.js"></script>
<script src="../js/pdv_controller.js"></script>
</html>