<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";
    
    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    //Recebe a solicitação de cadastro
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){

        include "utilities/mysql_connect.php";

        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $cargo = $_POST['cargo'];
        $tipo = $_POST['permissoes'];

        $query = mysqli_query($connection, "insert into usuarios(nome_user, email_user, senha_user, cpf_user, cargo_user, tipo_user) values ('$nome','$email','$senha','$cpf','$cargo','$tipo');");

        mysqli_close($connection);
        header("Location: tabelaFuncionarios.php");

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
                <form action='tabelaFuncionarios.php' method='post'><input type='hidden' name='id_delete' id='id' value='0'><button class='del'>Deletar</button></form>
                <a href='tabelaFuncionarios.php'><button class='cancel'>Cancelar</button></a>
            </div>
        </div>
        </div>";
    }

    function setForm($form_id){

        if($form_id == 0){
                echo"<div class='center-absolute'>
                <div class='header'>
                    <h1 id='titulo-form'>Novo Funcionário</h1>
                    <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
                </div>
                <form action='tabelaFuncionarios.php' method='post'>
                    <div class='form-holder'>
                        <div class='r-one'>
                            <div>
                                <label for='nome'>Nome:</label>
                                <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' requied>
                            </div>
                            <div>
                                <label for='cpf'>CPF:</label>
                                <input type='text' name='cpf' id='cpf' maxlength='14' onkeyup='mask_js(this.value, this, \"###.###.###-##\")' required>
                            </div>
                        </div>
            
                        <div class='r-two'>
                            <div>
                                <label for='email'>Email:</label>
                                <input type='email' name='email' id='email' oninput='noSlashes_js(this.value, this)' required>
            
                            </div>

                            <div>
                                <label for='senha'>Senha:</label>
                                <input type='text' name='senha' id='senha' oninput='noSlashes_js(this.value, this)' required>
                            </div>
            
                            <div>
                                <label for='cargo'>Cargo:</label>
                                <input type='text' name='cargo' id='cargo' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' required>
                            </div>
            
                            <div>
                                <label for='permissoes'>Permissões:</label>
                                <select name='permissoes' id='permissoes' required>
                                    <option value='' selected hidden></option>
                                    <option value='a'>Admnistrador</option>
                                    <option value='f'>Funcionário</option>
                                </select>
                            </div>
                        </div>
            
                        <input type='submit' name='cadastrar' id='cadastrar' value='Cadastrar'>
            
                    </div>
                </form>
            </div>";
        
        }else if($form_id == 1){
            echo"<div class='center-absolute'>
            <div class='header'>
            <h1 id='titulo-form'>Editar Funcionário</h1>
            <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href;'>
            </div>
            <form action='tabelaFuncionarios.php' method='post'>
            <input type='hidden' name='id' id='id'>
            <div class='form-holder'>
                <div class='r-one'>
                    <div>
                        <label for='nome'>Nome:</label>
                        <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' requied>
                    </div>
                    <div>
                        <label for='cpf'>CPF:</label>
                        <input type='text' name='cpf' id='cpf' maxlength='14' onkeyup='mask_js(this.value, this, '###.###.###-##')' required>
                    </div>
                </div>
                
                <div class='r-two'>
                    <div>
                        <label for='email'>Email:</label>
                        <input type='email' name='email' id='email' oninput='noSlashes_js(this.value, this)' required>
                
                    </div>
                
                    <div>
                        <label for='senha'>Senha:</label>
                        <input type='text' name='senha' id='senha' oninput='noSlashes_js(this.value, this)' required>
                    </div>
            
                    <div>
                        <label for='cargo'>Cargo:</label>
                        <input type='text' name='cargo' id='cargo' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' required>
                    </div>
            
                    <div>
                        <label for='permissoes'>Permissões:</label>
                        <select name='permissoes' id='permissoes' required>
                            <option value='' selected hidden></option>
                            <option value='a'>Admnistrador</option>
                            <option value='f'>Funcionário</option>
                        </select>
                    </div>
                </div>
            
                <input type='submit' name='atualizar' id='atualizar' value='Atualizar'>
            
            </div>
            </form>
            </div>";
        }

    }

    //Funções utilizadas na tabela
    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select nome_user, email_user, cpf_user, cargo_user, tipo_user, id_user from usuarios where nome_user like \"%$search%\";");

        while($output = mysqli_fetch_array($query)){

            echo"<tr class='normal-row'>";

            echo"<td>$output[0]</td>";
            echo"<td>$output[1]</td>";
            echo"<td>$output[2]</td>";
            echo"<td>$output[3]</td>";
            
            if(($_SESSION['user_flag'] == "d" || $output[4] == "f") && $output[4] != "d"){

                echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
                echo"<form action='tabelaFuncionarios.php' method='post'><input type='hidden' name='id_delete-confirmar' value='$output[5]'><button class='button' name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
                echo"<form action='tabelaFuncionarios.php' method='post'><input type='hidden' name='id_edit' value='$output[5]'><button class='button' name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
                echo"</div></td></tr>";
            
            }else{

                echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
                echo"<button class='disabled-button' name='delete' type='submit'><img src='../images/icons/delete.png'></button>";
                echo"<button class='disabled-button' name='edit' type='submit'><img src='../images/icons/edit.png'></button>";
                echo"</div></td></tr>";

            }

        }

        mysqli_close($connection);
        
    }

    //Funções das açãoes
    function edit($id){

        $info = [];

        $info[0] = $_POST['nome'];
        $info[1] = $_POST['email'];
        $info[2] = $_POST['senha'];
        $info[3] = $_POST['cpf'];
        $info[4] = $_POST['cargo'];
        $info[5] = $_POST['permissoes'];

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "update usuarios set nome_user='$info[0]', email_user='$info[1]', senha_user='$info[2]', cpf_user='$info[3]', cargo_user='$info[4]', tipo_user='$info[5]' where id_user=$id;");
        mysqli_close($connection);

        header("Location: tabelaFuncionarios.php");

    }

    function delete_item($id){
        include "utilities/mysql_connect.php";
        $query = mysqli_query($connection, "delete from usuarios where id_user = $id;");
        mysqli_close($connection);

        header("Location: tabelaFuncionarios.php");
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaFuncionarios.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Funcionários</title>
</head>

<body>

    <div class="navbar">
        <a href="adm_dashboard.php">
            <div class="logo"></div>
        </a>

        <h1>Funcionários</h1>
        <div class="menu">
            <button>Produtos</button>
            <button>Pedidos</button>

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

            <form action="tabelaFuncionarios.php" method="post" id="searchbox">
                <input type="text" placeholder="Pesquisar..." name="search" id="searchbar">
                <input type="submit" value="🔎︎">
                <a href="tabelaFuncionarios.php"><img src="../images/icons/close.png" id="close-search"></a>
            </form>

            <div id="menu">
                <button onclick=""><img src="../images/icons/report.png"></button>
                <form action="tabelaFuncionarios.php" method="post">
                    <input type="hidden" name="new-item" value="0">
                    <button><img src="../images/icons/plus.png"></button>
                </form>
            </div>

        </div>

        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                <th style="border-left: none;">Nome</th> <!-- nome_user -->
                <th>Email</th> <!-- email_user -->
                <th>CPF</th> <!-- cpf_user -->
                <th>Cargo</th> <!-- cargo_user -->
                <th style="border-right: none;">Ações</th></tr>

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
                echo'<script>console.log("WOW")</script>';
            
            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_edit'])){
                setForm(1);
            
                $id = $_POST['id_edit'];
        
                include "utilities/mysql_connect.php";

                $values = mysqli_fetch_array(mysqli_query($connection, "select nome_user, cpf_user, email_user, senha_user, cargo_user, tipo_user, id_user from usuarios where id_user=$id group by 1;"));
        
                echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('cpf').value = '$values[1]';
                    document.getElementById('email').value = '$values[2]';
                    document.getElementById('senha').value = '$values[3]';
                    document.getElementById('cargo').value = '$values[4]';
                    document.querySelector('#permissoes').value = '$values[5]';
                    document.getElementById('id').value = '$values[6]';

                </script>";

                mysqli_close($connection);
            
            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete-confirmar'])){
                show_delbox();

                $id = $_POST['id_delete-confirmar'];
        
                include "utilities/mysql_connect.php";
        
                $nome = mysqli_fetch_array(mysqli_query($connection, "select nome_user from usuarios where id_user=$id group by 1;"))[0];

                echo"<script>

                    document.getElementById('info').textContent = '$nome?';
                    document.getElementById('id').value = $id;
        
                </script>";
            }
        ?>

    </div>

</body>
<script src="../js/masks.js"></script> <!-- Pacote de máscaras -->
</html>