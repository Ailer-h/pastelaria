<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Recebe a solicitação de cadastro
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){

        include "utilities/mysql_connect.php";

        $nome = $_POST['nome'];
        $data_vencimento = $_POST['data-vencimento'];
        $valor_custo = $_POST['valor-custo'];
        $unidade_medida = $_POST['unidade-medida'];
        $qtd = $_POST['qtd'];
        $qtd_padrao = $_POST['qtd'];
        
        $query = mysqli_query($connection, "insert into estoque(nome_item,data_vencimento,valor_custo,unidade_medida,qtd,qtd_padrao) values ('$nome','$data_vencimento','$valor_custo','$unidade_medida','$qtd','$qtd_padrao');");

        mysqli_close($connection);
        
    }

    //Funções utilizadas na tabela
    function tratarData($data){
        $date_array = explode("-",$data);
        return $date_array[2]."/".$date_array[1]."/".$date_array[0];
    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select nome_item, data_vencimento, valor_custo, unidade_medida, qtd, qtd_padrao, id_item from estoque where nome_item like \"%$search%\" group by 1;");

        while($output = mysqli_fetch_array($query)){

            if($output[4] == 0){
                //Paint row red
            
            }else{
                
                $data = tratarData($output[1]);

                echo"<tr>";

                echo"<td>$output[0]</td>";
                echo"<td>$data</td>";
                echo"<td>$output[2]/$output[3]</td>";
                echo"<td>$output[4] $output[3]</td>";
                
                if($output[4] <= $output[5]*0.1){
                    echo"<td><div style='display: flex; justify-content: center; gap: .3em;'>";
                    echo"<div class='status' style='background-color:#E72929;'></div>";
                    echo"<div class='status'></div>";
                    echo"<div class='status'></div>";
                    echo"</div></td>";
                
                }else if($output[4] <= $output[5]*0.5){
                    echo"<td><div style='display: flex; justify-content: center; gap: .3em;'>";
                    echo"<div class='status'></div>";
                    echo"<div class='status' style='background-color:#FFC94A;'></div>";
                    echo"<div class='status'></div>";
                    echo"</div></td>";
                
                }else{
                    echo"<td><div style='display: flex; justify-content: center; gap: .3em;'>";
                    echo"<div class='status'></div>";
                    echo"<div class='status'></div>";
                    echo"<div class='status' style='background-color:#008000;'></div>";
                    echo"</div></td>";
                }
                        
                echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
                echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_delete' value='$output[6]'><button type='submit' name='delete'><img src='../images/icons/delete.png'></button></form>";
                echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_edit' value='$output[6]'><button type='submit' name='edit'><img src='../images/icons/edit.png'></button></form>";
                echo"</div></td></tr>";
            }

        }

        mysqli_close($connection);
        
    }

    //Funções das ações
    function delete($id){
        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "delete from estoque where id_item = $id;");
        mysqli_close($connection);

        header("Location: tabelaEstoque.php");
    }

    function edit($id)

    function callEditForm($id){

        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "select nome_item, data_vencimento, valor_custo, unidade_medida, qtd, qtd_padrao, id_item from estoque where id_item = $id group by 1;");
        $output = mysqli_fetch_array($query);

        //id="cadastrar"
        //id="atualizar"

        echo"<script>
            document.getElementById('add-item').style.display = 'block';
            document.getElementById('atualizar').style.display = 'block';
            document.getElementById('cadastrar').style.display = 'none';
            
            document.getElementById('titulo-form').textContent = 'Editar Matéria Prima';

            document.getElementById('nome').value = '$output[0]';
            document.getElementById('data-vencimento').value = '$output[1]';
            document.getElementById('valor-custo').value = '$output[2]';
            document.querySelector('#unidade-medida').value = '$output[3]';
            document.getElementById('qtd').value = '$output[4]';
        </script>";

    }

    //Recebe a solicitação de deleção
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete'])){
        delete($_POST['id_delete']);
    
    }

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

            <div id="filter">
                <form action="tabelaEstoque.php" method="post">
                    <input type="date" name="start-date" id="start-date">
                    <input type="date" name="end-date" id="end-date">
                    <input type="submit" value="Filtrar">
                </form>
                <button onclick="document.getElementById('add-item').style.display = 'block';"><img src="../images/icons/plus.png"></button>
            </div>

        </div>
       
        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;"><th style="border-left: none;">Nome</th><th>D. Vencimento</th><th>Custo (R$)</th><th>Qtd</th><th>Status</th><th style="border-right: none;">Ações</th></tr>
                <?php
                    table("");
                ?>
            </table>
        </div>
    </div>

    <div id="add-item">
        <div class="center-absolute">
            <div class="header">
                <h1 id="titulo-form">Nova Matéria Prima</h1>
                <img src="../images/icons/close.png" onclick="document.getElementById('add-item').style.display = 'none';">
            </div>
            <form action="tabelaEstoque.php" method="post">
            <div class="form-holder">
                    <div class="r-one">
                        <div>
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" requied>
                        </div>
                        <div>
                            <label for="data-vencimento">Data de Vencimento:</label>
                            <input type="date" name="data-vencimento" id="data-vencimento" required>
                        </div>
                    </div>
                    
                    <div class="r-two">
                        <div>
                            <label for="valor-custo">Valor de Custo:</label>
                            <input type="number" name="valor-custo" id="valor-custo" min="0.0001" step="any" required>
                        </div>

                        <div>
                            <label for="unidade-medida">Unidade de Medida:</label>
                            <select name="unidade-medida" id="unidade-medida" required>
                                <option value="" selected hidden></option>
                                <option value="g">g</option>
                                <option value="ml">ml</option>
                            </select>
                        </div>

                        <div>
                            <label for="qtd">Quantidade:</label>
                            <input type="number" name="qtd" id="qtd" min="1" step="1" class="qtd" required>
                        </div>
                    </div>

                    <input type="submit" name="cadastrar" id="cadastrar" value="Cadastrar">
                    <input type="submit" name="atualizar" id="atualizar" style="display: none;" value="Atualizar">
                    
                </div>
            </form>
        </div>
    </div>
    
    <?php
    
        //Recebe a solicitação de edição
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_edit'])){
            callEditForm($_POST['id_edit']);

        }
    
    ?>

</body>
</html>