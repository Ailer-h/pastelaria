<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    //Função para substituir pontos por virgula em valores monetários
    include "utilities/fixMoney.php";

    //Função que retorna uma data de filtro baseada na tag enviada
    include "utilities/getFilterDate.php";

    function getCost($id){
        include "utilities/mysql_connect.php";

        $val = mysqli_fetch_array(mysqli_query($connection, "select sum(qtd_ingrediente*preco_ingrediente) from ingredientes_prod where id_produto = $id group by id_produto;"))[0];

        mysqli_close($connection);

        return $val;
    }

    //Totais de vendas declarados como globais para uso posterior em script
    $GLOBALS['total_qtdVenda'] = 0;
    $GLOBALS['total_gastos'] = 0;
    $GLOBALS['total_receita'] = 0;
    $GLOBALS['total_saldo'] = 0;

    function table($filter){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_prod, nome_prod, valor_venda from produtos;");

        while($prod = mysqli_fetch_array($query)){

            $qtd_vendida = !empty(mysqli_fetch_array(mysqli_query($connection, "select sum(pp.qtd_prod) from produtos_pedido pp, pedidos pd where pp.id_pedido = pd.id_pedido and pp.id_prod = $prod[0] and $filter (pd.estado not like 'Cancelado') group by id_prod;"))) ? mysqli_fetch_array(mysqli_query($connection, "select sum(pp.qtd_prod) from produtos_pedido pp, pedidos pd where pp.id_pedido = pd.id_pedido and pp.id_prod = $prod[0] and $filter (pd.estado not like 'Cancelado') group by id_prod;"))[0] : 0;
            $qtd_cancelada = !empty(mysqli_fetch_array(mysqli_query($connection, "select sum(pp.qtd_prod) from produtos_pedido pp, pedidos pd where pp.id_pedido = pd.id_pedido and pp.id_prod = $prod[0] and $filter (pd.estado like 'Cancelado' and pd.pedido_iniciado is not null) group by id_prod;"))) ? mysqli_fetch_array(mysqli_query($connection, "select sum(pp.qtd_prod) from produtos_pedido pp, pedidos pd where pp.id_pedido = pd.id_pedido and pp.id_prod = $prod[0] and $filter (pd.estado like 'Cancelado' and pd.pedido_iniciado is not null) group by id_prod;"))[0] : 0;
            
            if($qtd_vendida > 0){
                
                $preco_custo = getCost($prod[0]);
                $gasto_total = $preco_custo * ($qtd_vendida + $qtd_cancelada);
                $receita = $prod[2] * $qtd_vendida;
                $saldo = $receita - $gasto_total;
                
                //Adicionando nos contadores de total
                $GLOBALS['total_qtdVenda'] += $qtd_vendida;
                $GLOBALS['total_gastos'] += $gasto_total;
                $GLOBALS['total_receita'] += $receita;
                $GLOBALS['total_saldo'] += $saldo;

                $color = $saldo > 0 ? "#00ae00" : "#E72929";

                echo"<tr class='normal-row'>";
                
                echo"<td>$prod[1]</td>";
                echo"<td>$qtd_vendida</td>";
                echo"<td>R$".fixMoney($gasto_total)."</td>";
                echo"<td>R$".fixMoney($receita)."</td>";
                echo"<td style='color: $color;'>R$".fixMoney($saldo)."</td>";
                
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
            <form action="relatorios.php" method="post">
                <div style="display: flex; align-items: center;">
                    <label for="date" id="lb_date">Especifique um dia: </label>
                    <input type="date" name="date" id="date" required>
                    <button class="search">🔎︎</button>
                    <img src="../images/icons/close.png" id="clearDate" onclick="location.href = location.href" style="display: none;">
                </div>
            </form>

            <div id="filter">
                <img src="../images/icons/close.png" id="clear" onclick="location.href = location.href" style="display: none;">
                <form action="relatorios.php" method="post" id='filterForm'>
                    <input type="hidden" name="filterTag" id="filterTag">
                </form>
                <button id='filterAno' onclick='filter("Ano")'>Esse ano</button>
                <button id='filterMes' onclick='filter("Mes")'>Esse mês</button>
                <button id='filterDia' onclick='filter("Dia")'>Hoje</button>
            </div>
        </div>
        <div class="reports">
            <table>
                <th style="border-left: none;">Produto</th>
                <th style="width: 10em;">Qtd Vendida</th>
                <th style="width: 10em;">Gastos</th>
                <th style="width: 10em;">Receita</th>
                <th style="border-right: none; width: 10em;">Saldo</th>

                <?php
                
                    if(isset($_POST['date'])){
                        $date = $_POST['date'];
                        table("pd.dataHora_pedido between '$date 00:00:00' and '$date 23:59:59' and");

                        echo"<script>
                            document.getElementById('date').value = '$date';
                            document.getElementById('clearDate').style.display = 'block';
                        </script>";

                    }else if(isset($_POST['filterTag'])){
                        $tag = $_POST['filterTag'];
                        $filter = getFilterDate($tag);

                        table("pd.dataHora_pedido >= '$filter' and");

                        echo"<script>
                            document.getElementById('filter$tag').className = 'selected';
                            document.getElementById('clear').style.display = 'block';
                            console.log('>= $filter and');
                        </script>";

                    }else{
                        table("");

                    }
                ?>
            
            </table>
        </div>
        <div class="total">
            <table>
                <th style="border-left: none; display: flex; justify-content: end;">
                    Total:
                </th>
                <?php
                    $color = $GLOBALS['total_saldo'] > 0 ? "#00ae00" : "#E72929";

                    echo"<th style='width: 10em;'>R$". fixMoney($GLOBALS['total_qtdVenda']) ."</th>";
                    echo"<th style='width: 10em;'>R$". fixMoney($GLOBALS['total_gastos']) ."</th>";
                    echo"<th style='width: 10em;'>R$". fixMoney($GLOBALS['total_receita']) ."</th>";
                    echo"<th style='border-right: none; width: 10em; color: $color;'>R$". fixMoney($GLOBALS['total_saldo']) ."</th>";
                ?>
            </table>
        </div>
    </div>
</body>
<script src="../js/reportFilter.js"></script>
</html>