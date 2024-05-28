<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";
    
    //Função para substituir pontos por virgula em valores monetários
    include "utilities/fixMoney.php";
    
    //Função que recebe a classe referente a tag de status
    include "utilities/getStatusClass.php";

    function getProducts($id){

        include "utilities/mysql_connect.php";

        $str_prods = "";

        $prods = mysqli_query($connection, "select pr.nome_prod, pp.qtd_prod from produtos_pedido pp, produtos pr where pp.id_prod = pr.id_prod and pp.id_pedido = $id;");

        while($output = mysqli_fetch_array($prods)){
            $str_prods = $str_prods."$output[0] x$output[1], ";
        }

        mysqli_close($connection);

        echo substr($str_prods, 0, -2).".";

    }

    function tratarData($data){
        $date_array = explode("-",$data);
        return $date_array[2]."/".$date_array[1]."/".$date_array[0];
    }

    function table(){
        
        date_default_timezone_set("America/Sao_Paulo");

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_pedido, estado, valor_total, pedido_iniciado, pedido_finalizado, dataHora_pedido from pedidos order by dataHora_pedido desc, estado;");

        while($output = mysqli_fetch_array($query)){

            $tag = "";

            $status_class = getStatusClass($output[1]);
            $price = fixMoney($output[2]);
            $arrayDate = explode("-", explode(" ", $output[5])[0]);
            $date = explode("-", date("Y-m-d"));
            
            //Da as tags de dia/mes/ano para o filtro
            if($arrayDate[0] == $date[0] && $arrayDate[1] == $date[1] && $arrayDate[2] == $date[2]){
                $tag = $tag."dia;";

            }

            if($arrayDate[0] == $date[0] && $arrayDate[1] == $date[1]){
                $tag = $tag."mes;";

            }

            if($arrayDate[0] == $date[0]){
                $tag = $tag."ano;";

            }

            echo"<script>console.log('$arrayDate[0]/$arrayDate[1]/$arrayDate[2]')</script>";
            echo"<script>console.log('$tag')</script>";

            if($output[1] != "Não Iniciado"){
                $date_time = explode(" ", $output[3]);
                $date = tratarData($date_time[0]);
                $time = $date_time[1];

            }else{
                $date = "---";
                $time = "";

            }


            if($output[1] == "Não Iniciado" || $output[1] == "Em Andamento"){
                $timer = "<i>00:00:00</i>";
            
            }else{
                
                $tempo_preparo = abs(strtotime($output[3]) - strtotime($output[4]));
                $hours = floor($tempo_preparo / 3600);
                $minutes = floor(($tempo_preparo % 3600) / 60);
                $seconds = $tempo_preparo % 60;

                $timer = sprintf("%02d", $hours) . ":" .
                sprintf("%02d", $minutes) . ":" .
                sprintf("%02d", $seconds);

            }

            if($output[1] == "Cancelado"){
                echo"<tr class='normal-row' style='display: none;' id='$tag-cancelado'>";
                
            }else{
                echo"<tr class='normal-row' id='$tag'>";

            }
            
            echo"<td style='max-width: 7em; padding-left: .5em; padding-right: .5em;'>";
            getProducts($output[0]);
            echo"</td>";
            echo"<td>R$$price</td>";
            echo"<td><div style='display: flex; justify-content: center;'><div class='$status_class'>$output[1]</div></div></td>";
            echo"<td><div>$date</div><div>$time</div></td>";
            echo"<td>$timer</td>";

            echo"</tr>";
            
        }
        mysqli_close($connection);

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaPedidos.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Produtos</title>
</head>
<body>

    <div class="navbar">
        <?php
            
            if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                echo"<a href='adm_dashboard.php'>
                        <div class='logo'></div>
                    </a>";
            
            }else{
                echo"<a href='user_dashboard.php'>
                        <div class='logo'></div>
                    </a>";
            }
        
        ?>

        <h1>Pedidos</h1>

        <div class="menu">

            <?php
        
                if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                    echo"<a href='tabelaProdutos.php'><button>Produtos</button></a>
                        <a href='cozinha.php'><button>Cozinha</button></a>
                        <a href='tabelaEstoque.php'><button>Estoque</button></a>";
                
                }else{
                    echo"<a href='cozinha.php'><button>Cozinha</button></a>";

                }
        
            ?>

            <div class="user-area">
                <?php

                $username = $_SESSION['username'];
                echo "<p>Olá $username!</p>";

                ?>
                <a href="sessionEnded.php">
                    <div class="logout"><img src="../images/icons/logout.png">
                        <p>Logout</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="center">
        <div class="table-header">
            <div id="filter">
                <button id='filterDia' onclick='filter("dia", this.id)'>Hoje</button>
                <button id='filterMes' onclick='filter("mes", this.id)'>Esse mês</button>
                <button id='filterAno' onclick='filter("ano", this.id)'>Esse ano</button>
                <img src="../images/icons/close.png" id="clean" onclick="cleanFilter()" style="display: none;">
            </div>

            <div id="menu">
                <div style="display: flex; justify-content: center; align-items: center; gap: .5em;">
                    <p>Mostrar pedidos cancelados</p>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <input type="checkbox" id='visibilityCheckbox' onclick="changeVisibiltyState()">
                        <label class='toggle' for="visibilityCheckbox"></label>
                    </div>
                </div>
                <a href='pdv.php'><button><img src="../images/icons/plus.png"></button></a>
            </div>

        </div>

        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;" id='header'>
                <th style="border-left: none;">Produtos Pedidos</th>
                <th>Valor Total</th>
                <th>Estado</th>
                <th>Iniciado em</th>
                <th style="border-right: none;">Tempo de Preparo</th></tr>

                <?php
                    table();
                ?>

            </table>
        </div>
    </div>

    <div id="form-box">

    </div>

</body>
<script src="../js/canceledOrder_manager.js"></script>
<script src="../js/filter.js"></script>
</html>