<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    //Função para substituir pontos por virgula em valores monetários
    include "utilities/fixMoney.php";

    function getCost($id){
        include "utilities/mysql_connect.php";

        $val = mysqli_fetch_array(mysqli_query($connection, "select sum(qtd_ingrediente*preco_ingrediente) from ingredientes_prod where id_produto = 1 group by id_produto;"))[0];

        mysqli_close($connection);

        return $val;
    }

    function table(){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_prod, nome_prod, valor_venda from produtos;");

        while($prod = mysqli_fetch_array($query)){

            $qtd_vendida = !empty(mysqli_fetch_array(mysqli_query($connection, "select sum(qtd_prod) from produtos_pedido where id_prod = $prod[0] group by id_prod;"))) ? mysqli_fetch_array(mysqli_query($connection, "select sum(qtd_prod) from produtos_pedido where id_prod = $prod[0] group by id_prod;"))[0] : 0;
            
            if($qtd_vendida > 0){
                
                $preco_custo = getCost($prod[0]);
                $gasto_total = $preco_custo * $qtd_vendida;
                $receita = $prod[2] * $qtd_vendida;
                $lucro = $receita - $gasto_total;
                
                echo"<tr class='normal-row'>";
                
                echo"<td>$prod[1]</td>";
                echo"<td>$qtd_vendida</td>";
                echo"<td>R$".fixMoney($gasto_total)."</td>";
                echo"<td>R$".fixMoney($receita)."</td>";
                echo"<td>R$".fixMoney($lucro)."</td>";
                
                echo"</tr>";
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
    <link rel="stylesheet" href="../css/relatorios.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Relatórios</title>
</head>
<body>
<div class="navbar">
        <a href="adm_dashboard.php">
        <div class="logo"></div>
        </a>

        <h1>Relatórios</h1>
        <div class="menu">

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
        <div class="header">
            <div style="display: flex;">
                <label for="specifier" id="lb_specifier">Especifique um dia: </label>
                <input type="date" name="specifier" id="specifier">
                <button class="search">🔎︎</button>
            </div>

            <div id="filter">
                <img src="../images/icons/close.png" id="clean" onclick="cleanFilter()" style="display: none;">
                <button id='filterAno' onclick='filter("ano", this.id)'>Esse ano</button>
                <button id='filterDia' onclick='filter("dia", this.id)'>Hoje</button>
                <button id='filterMes' onclick='filter("mes", this.id)'>Esse mês</button>
            </div>
        </div>
        <div class="reports">
            <table>
                <th style="border-left: none;">Produto</th>
                <th>Qtd Vendida</th>
                <th>Gastos</th>
                <th>Receita</th>
                <th style="border-right: none;">Lucro</th>

                <?php
                    table();
                ?>
            
            </table>
        </div>
    </div>
</body>
<script src="../js/reportFilter.js"></script>
</html>