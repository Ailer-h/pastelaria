<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])){

        $nome = $_POST['nome_cli'];
        $telefone = $_POST['telefone_cli'];
        $data = date('Y-m-d');
        $total = $_POST['valor-total'];

        $pedidos = json_decode($_POST['array_pedidos'],true);
        $estoque = json_decode($_POST['estoque'], true);
        $phones = json_decode($_POST['phoneNumbers'], true);

        $id_cli;

        //Pega o id do cliente na estrutura de dados dos telefones
        foreach($phones as $user){
            foreach(array_keys($user) as $number){
                if($number == $telefone){
                    $id_cli = $user[$number][2];
                }
            } 
        }

        include "utilities/mysql_connect.php";

        mysqli_query($connection, "insert into pedidos(id_cliente, data_pedido, valor_total, estado) values ('$id_cli', '$data', '$total', 'Não Iniciado');");

        $id_pedido = mysqli_fetch_array(mysqli_query($connection, "select id_pedido from pedidos order by id_pedido desc;"))[0];

        foreach($pedidos as $id){
            $qtd = $_POST['qtd'.$id];
            mysqli_query($connection, "insert into produtos_pedido(id_prod, qtd_prod, id_pedido) values ('$id', '$qtd', '$id_pedido');");
        }

        //Dá baixa no estoque
        foreach($estoque as $id => $item){
            mysqli_query($connection, "update estoque set qtd = '$item' where id_item = $id");
        }

        mysqli_close($connection);

    }

    function fixMoney($value){
        return str_replace(".", ",", sprintf("%1$.2f", $value));
    }

    function printNF(){
        
        include "utilities/mysql_connect.php";

        $id_pedido = mysqli_fetch_array(mysqli_query($connection, "select id_pedido from pedidos order by id_pedido desc;"))[0];

        echo"<script>console.log('$id_pedido')</script>";

        $query = mysqli_query($connection, "select prod.nome_prod, pp.qtd_prod, prod.valor_venda from pedidos pd, produtos_pedido pp, produtos prod where pp.id_prod = prod.id_prod and pp.id_pedido = $id_pedido GROUP BY prod.id_prod;");

        while($output = mysqli_fetch_array($query)){

            $val = fixMoney($output[2]);

            echo"<tr>";

            echo"<td>$output[0]</td>";
            echo"<td>$output[1]</td>";
            echo"<td>$val</td>";

            echo"</tr>";

        }

        $valor_total = mysqli_fetch_array(mysqli_query($connection, "select valor_total from pedidos where id_pedido = $id_pedido;"))[0];


        mysqli_close($connection);
    
        return $valor_total;

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/recibo.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Recibo</title>
</head>
<body>
    <div class="nota"> 
        <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])){
                echo"<div class='nome_cli'><h1>Nome: $nome</h1></div>";
                echo"<hr>";

                echo"<div class='tableHolder'><table>";
                echo"<tr style='position: sticky; top: 0;'><th style='border-left: none; width: 60%;'>Nome</th><th>Qtd</th><th>Preço</th><th style='border-right: none;></th></tr>";
                
                $valor_total = printNF();
                
                echo"</table></div>";

                echo"<p id='valor-total'>Valor Total - R$". fixMoney($valor_total) ."</p>";

            }
        ?>


    </div>
</body>

<script>
    window.print();

    window.onafterprint = () => {
        location.href = location.href.replace('recibo','pdv');
    }
</script>

</html>