<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){

        $cli_nome = $_POST['nome'];
        $cli_cell = $_POST['tel'];
        $cli_email = $_POST['email'];
        $cli_endereco = $_POST['endereco'];
        $cli_cpf = $_POST['cpf'];
        $cli_rg = $_POST['rg'];
        $cli_descricao = $_POST['descricao'];
        
        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "insert into clientes(cli_nome, cli_cel, cli_email, cli_endereco, cli_cpf,cli_rg, cli_descricao) values ('$cli_nome','$cli_cell','$cli_email','$cli_endereco','$cli_cpf','$cli_rg','$cli_descricao');");

        mysqli_close($connection);

        header("Location: tabelaClientes.php");

    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select cli_nome,cli_cel,cli_email,cli_endereco,cli_cpf,cli_rg, cli_id from clientes where cli_nome like \"%$search%\";");
        
        while($output = mysqli_fetch_array($query)){

            echo"<tr class='normal-row'>";

            echo"<td>$output[0]</td>";
            echo"<td>$output[1]</td>";
            echo"<td>$output[2]</td>";
            echo"<td>$output[3]</td>";
            echo"<td>$output[4]</td>";
            echo"<td>$output[5]</td>";
            
            echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";

            echo"<form action='tabelaClientes.php' method='post'><input type='hidden' name='id_info' value='$output[6]'>
            <button name='get_info' type='submit'><img src='../images/icons/info.png'></button>
            </form>";

            echo"<form action='tabelaClientes.php' method='post'><input type='hidden' name='id_delete-confirmar' value='$output[6]'>
            <button name='delete' type='submit'><img src='../images/icons/delete.png'></button>
            </form>";

            echo"<form action='tabelaClientes.php' method='post'><input type='hidden' name='id_edit' value='$output[6]'>
            <button name='edit' type='submit'><img src='../images/icons/edit.png'></button>
            </form>";

            echo"</div></td></tr>";

            echo"</tr>";
            
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
                <form action='tabelaClientes.php' method='post'><input type='hidden' name='id_delete' id='id' value='0'><button class='del'>Deletar</button></form>
                <a href='tabelaClientes.php'><button class='cancel'>Cancelar</button></a>
            </div>
        </div>
        </div>
        ";
    }

    function setForm($form_id){

        if($form_id == 0){
            echo"<div class='center-absolute'>
                    <div class='header'>
                    <h1 id='titulo-form'>Novo Cliente</h1>
                    <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
                </div>
                <form action='tabelaClientes.php' method='post'>
                    <div class='form-holder'>
                        <div class='half-1'>
                        <div class='r-one'>
                            <div>
                                <label for='nome'>Nome:</label>
                                <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this);' requied>
                            </div>
                            <div>
                                <label for='email'>Email:</label>
                                <input type='email' name='email' id='email' oninput='noBackslashes(this.value, this)' required>

                            </div>

                        </div>


                        <div class='r-two'>
                            <div>
                                <label for='endereco'>Endereço:</label>
                                <input type='text' name='endereco' id='endereco' oninput='noBackslashes(this.value, this)' required>
                        </div>

                            <div>
                                <label for='tel'>Telefone:</label>
                                <input type='text' name='tel' id='tel' maxlength='15' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"(##) #####-####\")' required>
                            </div>

                        </div>


                        <div class='r-three'>
                            <div>
                                <label for='cpf'>CPF:</label>
                                <input type='text' name='cpf' id='cpf' maxlength='14' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"###.###.###-##\")' required>
                            </div>
                            
                            <div>
                                <label for='rg'>RG:</label>
                                <input type='text' name='rg' id='rg' maxlength='12' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"##.###.###-#\")' required>
                            </div>
                        </div>

                        <input type='submit' name='cadastrar' id='cadastrar' value='Cadastrar'>
                        </div>
                        <div class='half-2'>
                            <div style='display: flex; flex-direction: column;'>
                                <label for='descricao'>Descrição:</label>
                                <textarea name='descricao' id='descricao' cols='30' rows='20' spellcheck='true' oninput='noBackslashes(this.value, this)' requied></textarea>
                            </div>
                        </div>
                    </div>
                </form>
                </div>";
        
        }else if($form_id == 1){
            echo"<div class='center-absolute'>
            <div class='header'>
            <h1 id='titulo-form'>Atualizar Cliente</h1>
            <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
        </div>
        <form action='tabelaClientes.php' method='post'>
            <input type='hidden' name='id' id='id'>
            <div class='form-holder'>
                <div class='half-1'>
                <div class='r-one'>
                    <div>
                        <label for='nome'>Nome:</label>
                        <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this);' requied>
                    </div>
                    <div>
                        <label for='email'>Email:</label>
                        <input type='email' name='email' id='email' oninput='noBackslashes(this.value, this)' required>

                    </div>

                </div>


                <div class='r-two'>
                    <div>
                        <label for='endereco'>Endereço:</label>
                        <input type='text' name='endereco' id='endereco' oninput='noBackslashes(this.value, this)' required>
                </div>

                    <div>
                        <label for='tel'>Telefone:</label>
                        <input type='text' name='tel' id='tel' maxlength='15' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"(##) #####-####\")' required>
                    </div>

                </div>


                <div class='r-three'>
                    <div>
                        <label for='cpf'>CPF:</label>
                        <input type='text' name='cpf' id='cpf' maxlength='14' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"###.###.###-##\")' required>
                    </div>
                    
                    <div>
                        <label for='rg'>RG:</label>
                        <input type='text' name='rg' id='rg' maxlength='12' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"##.###.###-#\")' required>
                    </div>
                </div>

                <input type='submit' name='atualizar' id='atualizar' value='Atualizar'>
                </div>
                <div class='half-2'>
                    <div style='display: flex; flex-direction: column;'>
                        <label for='descricao'>Descrição:</label>
                        <textarea name='descricao' id='descricao' cols='30' rows='20' spellcheck='true' oninput='noBackslashes(this.value, this)' requied></textarea>
                    </div>
                </div>
            </div>
        </form>
        </div>";
        }

    }

    //Funções das ações
    function delete_item($id){
        include "utilities/mysql_connect.php";
        mysqli_query($connection, "delete from clientes where cli_id = $id;");
        mysqli_close($connection);

        header("Location: tabelaClientes.php");
    }

    function edit($id){

        $info = [];

        $info[0] = $_POST['nome'];
        $info[1] = $_POST['tel'];
        $info[2] = $_POST['email'];
        $info[3] = $_POST['endereco'];
        $info[4] = $_POST['cpf'];
        $info[5] = $_POST['rg'];
        $info[6] = $_POST['descricao'];

        include "utilities/mysql_connect.php";
        mysqli_query($connection, "update clientes set cli_nome='$info[0]', cli_cel='$info[1]', cli_email='$info[2]', cli_endereco='$info[3]', cli_cpf='$info[4]', cli_rg='$info[5]', cli_descricao='$info[6]' where cli_id=$id");
        mysqli_close($connection);

        // header("Location: tabelaClientes.php");
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
    <link rel="stylesheet" href="../css/tabelaClientes.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Clientes</title>
</head>
<body>
    
    <div class="navbar">
        <a href="adm_dashboard.php">
        <div class="logo"></div>
        </a>

        <h1>Clientes</h1>
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
        
            <form action="tabelaClientes.php" method="post" id="searchbox">
                <input type="text" placeholder="Pesquisar..." name="search" id="searchbar">
                <input type="submit" value="🔎︎">
                <a href="tabelaClientes.php"><img src="../images/icons/close.png" id="close-search"></a>
            </form>

            <div id="menu">
                <button onclick=""><img src="../images/icons/report.png"></button>
                <form action="tabelaClientes.php" method="post">
                    <input type="hidden" name="new-item" value="0">
                    <button><img src="../images/icons/plus.png"></button>
                </form>
            </div>

        </div>
       
        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                    <th style="border-left: none;">Nome</th>
                    <th>Celular</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>CPF</th>
                    <th>RG</th>
                    <th style="border-right: none;">Ações</th>
                </tr>
                
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

                $values = mysqli_fetch_array(mysqli_query($connection, "select cli_nome, cli_cel, cli_email, cli_endereco, cli_cpf, cli_rg, cli_descricao, cli_id from clientes where cli_id=$id group by 1;"));

                echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('tel').value = '$values[1]';
                    document.getElementById('email').value = '$values[2]';
                    document.getElementById('endereco').value = '$values[3]';
                    document.getElementById('cpf').value = '$values[4]';
                    document.getElementById('rg').value = '$values[5]';
                    
                    document.getElementById('descricao').value = '$values[6]';

                    document.getElementById('id').value = $id;

                </script>";
                
            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete-confirmar'])){
                show_delbox();

                $id = $_POST['id_delete-confirmar'];
        
                include "utilities/mysql_connect.php";

                $nome = mysqli_fetch_array(mysqli_query($connection, "select cli_nome, cli_cel, cli_email, cli_endereco, cli_cpf, cli_rg, cli_descricao, cli_id from clientes where cli_id=$id group by 1;"))[0];

                echo"<script>

                    document.getElementById('info').textContent = '$nome?';
                    document.getElementById('id').value = $id;

                </script>";
            
            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_info'])){

                setForm(1);

                $id = $_POST['id_info'];
        
                include "utilities/mysql_connect.php";

                $values = mysqli_fetch_array(mysqli_query($connection, "select cli_nome, cli_cel, cli_email, cli_endereco, cli_cpf, cli_rg, cli_descricao, cli_id from clientes where cli_id=$id group by 1;"));

                echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('tel').value = '$values[1]';
                    document.getElementById('email').value = '$values[2]';
                    document.getElementById('endereco').value = '$values[3]';
                    document.getElementById('cpf').value = '$values[4]';
                    document.getElementById('rg').value = '$values[5]';
                    
                    document.getElementById('descricao').value = '$values[6]';

                    Array.from(document.getElementsByTagName('input')).forEach(e => {
                        e.disabled = true;
                    });
                    
                    document.getElementById('descricao').disabled = true;

                    document.getElementById('atualizar').style.display = 'none';
                    document.getElementById('titulo-form').textContent = 'Informações';

                </script>";

            }
    
        ?>

    </div>

</body>
<script src="../js/masks.js"></script>
</html>