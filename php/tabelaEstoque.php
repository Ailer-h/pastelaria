<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";
    include "utilities/checkPermissions.php";

    //Recebe a solicitação de cadastro
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){

        include "utilities/mysql_connect.php";

        $nome = $_POST['nome'];
        $data_vencimento = $_POST['data-vencimento'];
        $valor_custo = $_POST['valor-custo'];
        $unidade_medida = $_POST['unidade-medida'];
        $qtd = $_POST['qtd'];
        $qtd_padrao = $_POST['qtd-controle'];
        
        $query = mysqli_query($connection, "insert into estoque(nome_item,data_vencimento,valor_custo,unidade_medida,qtd,qtd_padrao) values ('$nome','$data_vencimento','$valor_custo','$unidade_medida','$qtd','$qtd_padrao');");

        mysqli_close($connection);
        
    }

    //Funções utilizadas na tabela
    function tratarData($data){
        $date_array = explode("-",$data);
        return $date_array[2]."/".$date_array[1]."/".$date_array[0];
    }

    function getPercentageShow($n, $total){
        $percent = (100*$n)/$total;

        if($percent > 100){
            return 100;
        
        }
        
        return $percent;
    }

    function getPercentageReal($n, $total){
        return round((100*$n)/$total, 2);
    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select nome_item, data_vencimento, valor_custo, unidade_medida, qtd, qtd_padrao, id_item from estoque where nome_item like \"%$search%\";");

        while($output = mysqli_fetch_array($query)){

            if($output[4] == 0){
                echo"<tr class='dead-row'>";
                
            }else if($output[4] <= $output[5]*0.1){
                echo"<tr class='red-row'>";
                
                
            }else{
                echo"<tr class='normal-row'>";

            }

            $data = tratarData($output[1]);
            $percentageShow = getPercentageShow($output[4], $output[5]);
            $percentageReal = getPercentageReal($output[4], $output[5]);

            echo"<td>$output[0]</td>";
            echo"<td>$data</td>";
            echo"<td>$output[2]/$output[3]</td>";
            echo"<td>$output[4] $output[3]</td>";
                
            if($output[4] <= $output[5]*0.1){
                echo"<td style='width: 12em;'><div style='display: flex; justify-content: start; align-items: center; gap: .3em;'>";
                echo"<div class='bar-holder'><div class='bar' style='width: $percentageShow%; background-color: #E72929;'></div></div>";
                echo"<p>$percentageReal%</p>";
                echo"</div></td>";
                
            }else if($output[4] <= $output[5]*0.5){
                echo"<td style='width: 12em;'><div style='display: flex; justify-content: start; align-items: center; gap: .3em;'>";
                echo"<div class='bar-holder'><div class='bar' style='width: $percentageShow%; background-color: #FFC94A;'></div></div>";
                echo"<p>$percentageReal%</p>";
                echo"</div></td>";
                
            }else{
                echo"<td style='width: 12em;'><div style='display: flex; justify-content: start; align-items: center; gap: .3em;'>";
                echo"<div class='bar-holder'><div class='bar' style='width: $percentageShow%; background-color: #00ae00;'></div></div>";
                echo"<p>$percentageReal%</p>";
                echo"</div></td>";
            }
                        
            echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
            echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_delete' value='$output[6]'><button name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
            echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_edit' value='$output[6]'><button name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
            echo"</div></td></tr>";

        }

        mysqli_close($connection);
        
    }

    //Funções das ações
    function delete_item($id){
        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "delete from estoque where id_item = $id;");
        mysqli_close($connection);

        header("Location: tabelaEstoque.php");
    }

    function edit($id){

        $info = [];

        $info[0] = $_POST['nome'];
        $info[1] = $_POST['data-vencimento'];
        $info[2] = $_POST['valor-custo'];
        $info[3] = $_POST['unidade-medida'];
        $info[4] = $_POST['qtd'];
        $info[5] = $_POST['qtd-controle'];

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "update estoque set nome_item='$info[0]', data_vencimento='$info[1]', valor_custo='$info[2]', unidade_medida='$info[3]', qtd='$info[4]', qtd_padrao='$info[5]' where id_item=$id;");
        mysqli_close($connection);

        header("Location: tabelaEstoque.php");

    }

    //Recebe a solicitação de deleção
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete'])){
        delete_item($_POST['id_delete']);
    
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])){
        edit($_POST['id']);
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaEstoque.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Estoque</title>
</head>
<body>
    
    <div class="navbar">
        <a href="adm_dashboard.php">
        <div class="logo"></div>
        </a>

        <h1>Estoque</h1>
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
                <?php

                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])){
                        $search = $_POST['search'];
                        table($search);

                        echo "<script>
                                document.getElementById('searchbar').value='$search'
                                document.getElementById('close-search').style.display = 'block'
                            </script>";
                    
                    }else{
                        table("");

                    }

                ?>
            </table>
        </div>
    </div>

    <div id="form-box">
    </div>

</body>
<script src="../js/handleForms_estoque.js"></script>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_edit'])){
        
        $id = $_POST['id_edit'];
        
        include "utilities/mysql_connect.php";

        $values = mysqli_fetch_array(mysqli_query($connection, "select nome_item, data_vencimento, valor_custo, unidade_medida, qtd, qtd_padrao, id_item from estoque where id_item=$id group by 1;"));
        
        echo"<script>
            console.log('wow')
            setForm(1);

            document.getElementById('nome').value = '$values[0]';
            document.getElementById('data-vencimento').value = '$values[1]';
            document.getElementById('valor-custo').value = '$values[2]';
            document.getElementById('unidade-medida').value = '$values[3]';
            document.getElementById('qtd').value = '$values[4]';
            document.getElementById('qtd-controle').value = '$values[5]';
            document.getElementById('id').value = '$values[6]';

        </script>";

        mysqli_close($connection);

    }

?>