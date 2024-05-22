<?php

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])){

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
</head>
<body>
    
</body>
</html>