<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Checa se o usuário tem permissões para entrar na pagina
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
        
        $search_nome = mysqli_fetch_array(mysqli_query($connection, "select nome_item from estoque where nome_item like '$nome'"));

        if(empty($search_nome)){

            $query = mysqli_query($connection, "insert into estoque(nome_item,data_vencimento,valor_custo,unidade_medida,qtd,qtd_padrao) values ('$nome','$data_vencimento','$valor_custo','$unidade_medida','$qtd','$qtd_padrao');");

            mysqli_close($connection);
            header("Location: tabelaEstoque.php");
        
        }else{
            echo"<script>alert('Matéria prima já cadastrada')</script>";
        }
        
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

    function fixMoney($value){
        return str_replace(".", ",", sprintf("%1$.2f", $value));
    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select nome_item, data_vencimento, valor_custo, unidade_medida, qtd, qtd_padrao, id_item from estoque where nome_item like \"%$search%\";");

        while($output = mysqli_fetch_array($query)){

            if($output[4] == 0){
                echo"<tr class='dead-row'>";
                
            }else if($output[4] <= $output[5]*0.1){
                echo"<tr class='alert'>";
                
                
            }else{
                echo"<tr class='normal-row'>";

            }

            $data = tratarData($output[1]);
            $percentageShow = getPercentageShow($output[4], $output[5]);
            $percentageReal = getPercentageReal($output[4], $output[5]);
            $preco = fixMoney($output[2]);

            echo"<td>$output[0]</td>";
            echo"<td>$data</td>";
            echo"<td>$preco/$output[3]</td>";
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
            echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_delete-confirmar' value='$output[6]'><button name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
            echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_edit' value='$output[6]'><button name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
            echo"</div></td></tr>";

        }

        mysqli_close($connection);
        
    }

    function show_delbox(){
        echo"<div class='center-absolute'>
        <div class='delete-header'>
            <img src='../images/icons/close.png' onclick='location.href = location.href'>
        </div>
        <div class='delete-form'>
            <div style='display: flex; align-items: center; flex-direction: column;'>
                <h1>Você deseja deletar as informações de</h1>
                <h1 id='info'>[nome]</h1>
            </div>
        
            <div class='btns'>
                <form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_delete' id='id' value='0'><button class='del'>Deletar</button></form>
                <a href='tabelaEstoque.php'><button class='cancel'>Cancelar</button></a>
            </div>
        </div>
        </div>
        ";
    }

    function setForm($form_id){

        if($form_id == 0){
            
            echo"<div class='center-absolute'>
                <div class='header'>
                    <h1 id='titulo-form'>Nova Matéria Prima</h1>
                    <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
                </div>
                <form action='tabelaEstoque.php' method='post'>
                <div class='form-holder'>
                        <div class='r-one'>
                            <div>
                                <label for='nome'>Nome:</label>
                                <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' requied>
                            </div>
                            <div>
                                <label for='data-vencimento'>Data de Vencimento:</label>
                                <input type='date' name='data-vencimento' id='data-vencimento' required>
                            </div>
                        </div>

                        <div class='r-two'>
                            <div>
                                <label for='valor-custo'>Valor da unidade:</label>
                                <input type='number' name='valor-custo' id='valor-custo' min='0.0001' step='any' required>
                            </div>

                            <div>
                                <label for='unidade-medida'>Unidade de Medida:</label>
                                <select name='unidade-medida' id='unidade-medida' required>
                                    <option value='' selected hidden></option>
                                    <option value='g'>g</option>
                                    <option value='ml'>ml</option>
                                </select>
                            </div>

                            <div>
                                <label for='qtd'>Qtd:</label>
                                <input type='number' name='qtd' id='qtd' min='0' step='1' class='qtd' oninput='int_js(this.value, this)' required>
                            </div>

                            <div>
                                <label for='qtd'>Qtd Padrão:</label>
                                <input type='number' name='qtd-controle' id='qtd-controle' min='0' step='1' class='qtd' oninput='int_js(this.value, this)' required>
                            </div>
                        </div>

                        <input type='submit' name='cadastrar' id='cadastrar' value='Cadastrar'>

                    </div>
                </form>
            </div>";
        
        }else if($form_id == 1){
            echo"<div class='center-absolute'>
            <div class='header'>
                <h1 id='titulo-form'>Editar Matéria Prima</h1>
                <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
            </div>
            <form action='tabelaEstoque.php' method='post'>
            <input type='hidden' name='id' id='id'>
            <div class='form-holder'>
                    <div class='r-one'>
                        <div>
                            <label for='nome'>Nome:</label>
                            <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' requied>
                        </div>
                        <div>
                            <label for='data-vencimento'>Data de Vencimento:</label>
                            <input type='date' name='data-vencimento' id='data-vencimento' required>
                        </div>
                    </div>
                    
                    <div class='r-two'>
                        <div>
                            <label for='valor-custo'>Valor da unidade:</label>
                            <input type='number' name='valor-custo' id='valor-custo' min='0.0001' step='any' required>
                        </div>
            
                        <div>
                            <label for='unidade-medida'>Unidade de Medida:</label>
                            <select name='unidade-medida' id='unidade-medida' required>
                                <option value='' selected hidden></option>
                                <option value='g'>g</option>
                                <option value='ml'>ml</option>
                            </select>
                        </div>
            
                        <div>
                            <label for='qtd'>Qtd:</label>
                            <input type='number' name='qtd' id='qtd' min='0' step='1' class='qtd' oninput='int_js(this.value, this)' required>
                        </div>
            
                        <div>
                            <label for='qtd'>Qtd Padrão:</label>
                            <input type='number' name='qtd-controle' id='qtd-controle' min='0' step='1' class='qtd' oninput='int_js(this.value, this)' required>
                        </div>
                    </div>
            
                    <input type='submit' name='atualizar' id='atualizar' value='Atualizar'>
                    
                </div>
            </form>
            </div>";
        }
        
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

    //Recebe a solicitação de edição
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
            <a href="tabelaProdutos.php"><button>Produtos</button></a>
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
                <form action="tabelaEstoque.php" method="post">
                    <input type="hidden" name="new-item" value="0">
                    <button><img src="../images/icons/plus.png"></button>
                </form>
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
        <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new-item'])){
                setForm(0);
            
            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_edit'])){
                setForm(1);

                $id = $_POST['id_edit'];
        
                include "utilities/mysql_connect.php";

                $values = mysqli_fetch_array(mysqli_query($connection, "select nome_item, data_vencimento, valor_custo, unidade_medida, qtd, qtd_padrao, id_item from estoque where id_item=$id group by 1;"));
        
                echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('data-vencimento').value = '$values[1]';
                    document.getElementById('valor-custo').value = '$values[2]';
                    document.getElementById('unidade-medida').value = '$values[3]';
                    document.getElementById('qtd').value = '$values[4]';
                    document.getElementById('qtd-controle').value = '$values[5]';
                    document.getElementById('id').value = '$values[6]';

                </script>";

                mysqli_close($connection);

            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete-confirmar'])){
                show_delbox();

                $id = $_POST['id_delete-confirmar'];
        
                include "utilities/mysql_connect.php";

                $nome = mysqli_fetch_array(mysqli_query($connection, "select nome_item from estoque where id_item=$id group by 1;"))[0];

                echo"<script>

                    document.getElementById('info').textContent = '$nome?';
                    document.getElementById('id').value = $id;

                </script>";
            }
        
        ?>
    </div>

</body>
<script src="../js/masks.js"></script>
</html>