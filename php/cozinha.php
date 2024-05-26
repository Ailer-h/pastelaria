<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Função que recebe a classe referente a tag de status
    include "utilities/getStatusClass.php";

    function getProductIds($id){

        $array = array();

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_prod, qtd_prod from produtos_pedido where id_pedido = $id;");
            
        while($output = mysqli_fetch_array($query)){
            array_push($array, array($output[0], $output[1]));
        }

        mysqli_close($connection);

        return $array;
    }

    //Função que recebe o id do produto desejado e retorna seus ingredientes em forma de um JSON
    function getRecipe($id){

        include "utilities/mysql_connect.php";
        $array = array();

        $prods = getProductIds($id);

        foreach($prods as $item){
            $query = mysqli_query($connection, "select qtd_ingrediente, id_ingrediente from ingredientes_prod where id_produto = $item[0];");
            
            while($output = mysqli_fetch_array($query)){
                array_push($array, array($output[1] => ($output[0] * $item[1])));
            }
        }

        mysqli_close($connection);

        return json_encode($array);

    }

    //Função que retorna todos os elementos do estoque em forma de JSON
    function getStock(){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_item, qtd from estoque;");
        $array = array();

        while($output = mysqli_fetch_array($query)){
            array_push($array, array($output[0] => $output[1]));

        }

        mysqli_close($connection);
        
        return json_encode($array);

    }

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

    function table(){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_pedido, estado from pedidos WHERE estado not in ('Cancelado', 'Concluído') and dataHora_pedido >= CURRENT_DATE;");

        while($output = mysqli_fetch_array($query)){

            $status_class = getStatusClass($output[1]);
            $recipe = getRecipe($output[0]);

            echo"<tr class='normal-row'>";
            
            echo"<td style='max-width: 5em; padding-left: .5em; padding-right: .5em;'>";
            getProducts($output[0]);
            echo"</td>";

            echo"<td id='timer$output[0]'>00:00:00</td>";
            echo"<td><div style='display: flex; justify-content: center; gap: 1em;'><div class='$status_class'>$output[1]</div></div></td>";
            echo"<td><div id='actions$output[0]' style='display: flex; justify-content: center; gap: 1em;'>";
            
            if($output[1] == "Não Iniciado"){
                echo"<button type='button' onclick='start($output[0])'><img src='../images/icons/play.png'></button>";
                echo"<button type='button' onclick='cancel($output[0],false)'><img src='../images/icons/close.png'></button>";
            
            }else{
                echo"<button type='button' onclick='done($output[0])'><img src='../images/icons/done.png'></button>";
                echo"<button type='button' onclick='cancel($output[0],true)'><img src='../images/icons/close.png'></button>";
            
            }

            echo"</div></td>";

            //Metadata para os itens
            echo"<input type='hidden' name='recipe$output[0]' id='recipe$output[0]' value='$recipe'>";
            echo"<input type='hidden' name='newState$output[0]' id='newState$output[0]'>";

            echo"</tr>";

        }

    }

    //<button><img src='../images/icons/done.png'></button>

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatedProd'])){

        $id = $_POST['updatedProd'];
        $newState = $_POST['newState'.$id];

        include "utilities/mysql_connect.php";

        if($newState == "Em Andamento"){
            $starttime = date('Y-m-d H:i:s');
            mysqli_query($connection, "update pedidos set estado = '$newState', pedido_iniciado = '$starttime' where id_pedido = $id;");

        }else{
            $endtime = date('Y-m-d H:i:s');
            mysqli_query($connection, "update pedidos set estado = '$newState', pedido_finalizado = '$endtime' where id_pedido = $id;");
        
        }

        $estoque = json_decode($_POST['estoque'], true);

        if($newState == "Cancelado"){

            //Retorna os itens pro estoque
            foreach($estoque as $id => $item){
                mysqli_query($connection, "update estoque set qtd = '$item' where id_item = $id");
            }
            
        }
        
        mysqli_close($connection);
        header("Location: cozinha.php");

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cozinha.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Pedidos</title>
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

        <h1>Pedidos Abertos</h1>
        
        <div class="menu">

            <?php
        
                if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                    echo"<a href='tabelaProdutos.php'><button>Produtos</button></a>
                        <a href='cozinha.php'><button>Cozinha</button></a>
                        <button>Pedidos</button>";
            
                }else{
                    echo"<a href='pdv.php'><button>PDV</button></a>
                        <a href=''><button>Pedidos</button></a>";

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

    <div class="table-holder">
        <table>
            <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                <th style='border-left: none;'>Produtos do Pedido</th>
                <th>Tempo do Pedido</th>
                <th>Estado do Pedido</th>
                <th style='border-right: none;'>Ações</th>
            </tr>

            <form action="cozinha.php" method="post" id='infos'>
                <input type="hidden" name="updatedProd" id="updatedProd">
                <?php

                    $estoque = getStock();
                    echo "<input type='hidden' id='estoque' name='estoque' value='$estoque'>";

                    table();
                ?>
            </form>

        </table>
    </div>

</body>
<script src="../js/orderHandler.js"></script>
</html>