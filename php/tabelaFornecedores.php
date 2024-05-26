<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cnpj = $_POST['cnpj'];
        $endereco = $_POST['endereco'];
        $ramo = $_POST['ramo'];
        $produto = $_POST['produto'];
        $descricao = $_POST['descricao'];
        $tel1 = $_POST['tel1'];
        $tel2 = isset($_POST['tel2']) ? $_POST['tel2'] : null;

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "insert into fornecedores(nome,celular1,celular2,email,endereco,cnpj,descricao,ramo_atividade,produto_oferecido) values ('$nome','$tel1','$tel2','$email','$endereco','$cnpj','$descricao','$ramo','$produto');");

        mysqli_close($connection);

    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select nome, celular1, celular2, cnpj, produto_oferecido, id_fornecedor from fornecedores where nome like \"%$search%\";");

        while($output = mysqli_fetch_array($query)){

            $produto = mysqli_fetch_array(mysqli_query($connection, "select nome_item from estoque where id_item=$output[4]"))[0];

            echo"<tr class='normal-row'>";

            echo"<td>$output[0]</td>";
            echo"<td>
                <div>$output[1]</div>
                <div>$output[2]</div>
            </td>";
            echo"<td>$output[3]</td>";
            echo"<td>$produto</td>";
            
            echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
            echo"<form action='tabelaFornecedores.php' method='post'><input type='hidden' name='id_info' value='$output[5]'><button name='get_info' type='submit'><img src='../images/icons/info.png'></button></form>";
            echo"<form action='tabelaFornecedores.php' method='post'><input type='hidden' name='id_delete-confirmar' value='$output[5]'><button name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
            echo"<form action='tabelaFornecedores.php' method='post'><input type='hidden' name='id_edit' value='$output[5]'><button name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
            echo"</div></td></tr>";

            echo"</tr>";
            
        }

        mysqli_close($connection);

    }

    function get_products(){

        include "utilities/mysql_connect.php";

        $query = mysqli_query( $connection,"select id_item, nome_item from estoque;");

        while($output = mysqli_fetch_array($query)){
            echo "<option value='$output[0]'>$output[1]</option>";
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
                <form action='tabelaFornecedores.php' method='post'><input type='hidden' name='id_delete' id='id' value='0'><button class='del'>Deletar</button></form>
                <a href='tabelaFornecedores.php'><button class='cancel'>Cancelar</button></a>
            </div>
        </div>
        </div>
        ";
    }

    function setForm($form_id){

        if($form_id == 0){
            echo"<div class='center-absolute'>
                    <div class='header'>
                    <h1 id='titulo-form'>Novo Fornecedor</h1>
                    <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
                </div>
                <form action='tabelaFornecedores.php' method='post'>
                    <div class='form-holder'>
                        <div class='half-1'>
                        <div class='r-one'>
                            <div>
                                <label for='nome'>Nome:</label>
                                <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this);' requied>
                            </div>
                            <div>
                                <label for='cnpj'>CNPJ:</label>
                                <input type='text' name='cnpj' id='cnpj' maxlength='20' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"##.###.###/####-##\")' required>
                            </div>

                            <div>
                                <label for='produto'>Produto:</label>
                                <select name='produto' id='produto' required>
                                    <option value='' selected hidden></option>";
                                    get_products();
                            echo"</select>
                            </div>

                        </div>

                        <div class='r-two'>
                            <div>
                                <label for='email'>Email:</label>
                                <input type='email' name='email' id='email' oninput='noBackslashes(this.value, this)' required>

                            </div>

                            <div>
                                <label for='ramo'>Ramo de Atividade:</label>
                                <input type='text' name='ramo' id='ramo' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' required>
                            </div>

                            <div>
                                <label for='tel1'>Telefones:</label>
                                <input type='text' name='tel1' id='tel1' placeholder='Telefone...' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"(##)#####-####\")' required>
                                <input type='text' name='tel2' id='tel2' placeholder='Telefone (Opcional)...' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"(##)#####-####\")'>
                            </div>

                        </div>

                        <div class='r-three'>
                            <label for='endereco'>Endereço:</label>
                            <input type='text' name='endereco' id='endereco' oninput='noBackslashes(this.value, this)' required>
                        </div>

                        <input type='submit' name='cadastrar' id='cadastrar' value='Cadastrar'>
                        </div>
                        <div class='half-2'>
                            <div style='display: flex; flex-direction: column;'>
                                <label for='descricao'>Descrição:</label>
                                <textarea name='descricao' id='descricao' cols='30' rows='20' spellcheck='true' oninput='noBackslashes(this.value, this)'></textarea>
                            </div>
                        </div>
                    </div>
                </form>
                </div>";
        
        }else if($form_id == 1){
            echo"<div class='center-absolute'>
            <div class='header'>
            <h1 id='titulo-form'>Editar Fornecedor</h1>
            <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
        </div>
        <form action='tabelaFornecedores.php' method='post'>
            <input type='hidden' name='id' id='id'>
            <div class='form-holder'>
                <div class='half-1'>
                <div class='r-one'>
                    <div>
                        <label for='nome'>Nome:</label>
                        <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this);' requied>
                    </div>
                    <div>
                        <label for='cnpj'>CNPJ:</label>
                        <input type='text' name='cnpj' id='cnpj' maxlength='20' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"##.###.###/####-##\")' required>
                    </div>

                    <div>
                        <label for='produto'>Produto:</label>
                        <select name='produto' id='produto' required>
                            <option value='' selected hidden></option>";
                            get_products();
                    echo"</select>
                    </div>

                </div>

                <div class='r-two'>
                    <div>
                        <label for='email'>Email:</label>
                        <input type='email' name='email' id='email' oninput='noBackslashes(this.value, this)' required>

                    </div>

                    <div>
                        <label for='ramo'>Ramo de Atividade:</label>
                        <input type='text' name='ramo' id='ramo' oninput='noBackslashes(this.value, this); letters_js(this.value, this)' required>
                    </div>

                    <div>
                        <label for='tel1'>Telefones:</label>
                        <input type='text' name='tel1' id='tel1' placeholder='Telefone...' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"(##)#####-####\")' required>
                        <input type='text' name='tel2' id='tel2' placeholder='Telefone (Opcional)...' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, \"(##)#####-####\")'>
                    </div>

                </div>

                <div class='r-three'>
                    <label for='endereco'>Endereço:</label>
                    <input type='text' name='endereco' id='endereco' oninput='noBackslashes(this.value, this)' required>
                </div>

                <input type='submit' name='atualizar' id='atualizar' value='Atualizar'>
                </div>
                <div class='half-2'>
                    <div style='display: flex; flex-direction: column;'>
                        <label for='descricao'>Descrição:</label>
                        <textarea name='descricao' id='descricao' cols='30' rows='20' spellcheck='true' oninput='noBackslashes(this.value, this)'></textarea>
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
        mysqli_query($connection, "delete from fornecedores where id_fornecedor = $id;");
        mysqli_close($connection);

        header("Location: tabelaFornecedores.php");
    }

    function edit($id){

        $info = [];

        $info[0] = $_POST['nome'];
        $info[1] = $_POST['tel1'];
        $info[2] = isset($_POST['tel2']) ? $_POST['tel2'] : null;
        $info[3] = $_POST['email'];
        $info[4] = $_POST['endereco'];
        $info[5] = $_POST['cnpj'];
        $info[6] = $_POST['descricao'];
        $info[7] = $_POST['ramo'];
        $info[8] = $_POST['produto'];

        include "utilities/mysql_connect.php";
        mysqli_query($connection, "update fornecedores set nome='$info[0]', celular1='$info[1]', celular2='$info[2]', email='$info[3]', endereco='$info[4]', cnpj='$info[5]', descricao='$info[6]', ramo_atividade='$info[7]', produto_oferecido='$info[8]' where id_fornecedor=$id");
        mysqli_close($connection);

        header("Location: tabelaFornecedores.php");
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
    <link rel="stylesheet" href="../css/tabelaFornecedores.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Estoque</title>
</head>
<body>
    
    <div class="navbar">
        <a href="adm_dashboard.php">
        <div class="logo"></div>
        </a>

        <h1>Fornecedores</h1>
        <div class="menu">
        <a href="tabelaClientes.php"><button>Clientes</button></a>
            <a href="tabelaFuncionarios.php"><button>Funcionários</button></a>
            
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
        
            <form action="tabelaFornecedores.php" method="post" id="searchbox">
                <input type="text" placeholder="Pesquisar..." name="search" id="searchbar">
                <input type="submit" value="🔎︎">
                <a href="tabelaFornecedores.php"><img src="../images/icons/close.png" id="close-search"></a>
            </form>

            <div id="menu">
                <form action="tabelaFornecedores.php" method="post">
                    <input type="hidden" name="new-item" value="0">
                    <button><img src="../images/icons/plus.png"></button>
                </form>
            </div>

        </div>
       
        <div class="table-holder">
            <table>
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                    <th style="border-left: none;">Nome</th>
                    <th>Celulares</th>
                    <th>CNPJ</th>
                    <th>Produto Oferecido</th>
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

                $values = mysqli_fetch_array(mysqli_query($connection, "select nome, celular1, celular2, email, endereco, cnpj, descricao, ramo_atividade, produto_oferecido, id_fornecedor from fornecedores where id_fornecedor=$id group by 1;"));

                echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('tel1').value = '$values[1]';
                    document.getElementById('tel2').value = '$values[2]';
                    document.getElementById('email').value = '$values[3]';
                    document.getElementById('endereco').value = '$values[4]';
                    document.getElementById('cnpj').value = '$values[5]';
                    
                    document.getElementById('descricao').value = '$values[6]';

                    document.getElementById('ramo').value = '$values[7]';
                    document.querySelector('#produto').value = '$values[8]';
                    document.getElementById('id').value = '$values[9]';

                </script>";
                
            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_delete-confirmar'])){
                show_delbox();

                $id = $_POST['id_delete-confirmar'];
        
                include "utilities/mysql_connect.php";

                $nome = mysqli_fetch_array(mysqli_query($connection, "select nome from fornecedores where id_fornecedor=$id group by 1;"))[0];

                echo"<script>

                    document.getElementById('info').textContent = '$nome?';
                    document.getElementById('id').value = $id;

                </script>";
            
            }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_info'])){

                setForm(1);

                $id = $_POST['id_info'];
        
                include "utilities/mysql_connect.php";

                $values = mysqli_fetch_array(mysqli_query($connection, "select nome, celular1, celular2, email, endereco, cnpj, descricao, ramo_atividade, produto_oferecido, id_fornecedor from fornecedores where id_fornecedor=$id group by 1;"));

                echo"<script>

                    document.getElementById('nome').value = '$values[0]';
                    document.getElementById('tel1').value = '$values[1]';
                    document.getElementById('tel2').value = '$values[2]';
                    document.getElementById('email').value = '$values[3]';
                    document.getElementById('endereco').value = '$values[4]';
                    document.getElementById('cnpj').value = '$values[5]';
                    
                    document.getElementById('descricao').value = '$values[6]';

                    document.getElementById('ramo').value = '$values[7]';
                    document.querySelector('#produto').value = '$values[8]';
                    document.getElementById('id').value = '$values[9]';

                    Array.from(document.getElementsByTagName('input')).forEach(e => {
                        e.disabled = true;
                    });
                    
                    document.getElementById('descricao').disabled = true;
                    document.querySelector('#produto').disabled = true;

                    document.getElementById('atualizar').style.display = 'none';
                    document.getElementById('titulo-form').textContent = 'Informações';

                </script>";

            }
    
        ?>

    </div>

</body>
<script src="../js/masks.js"></script>
</html>