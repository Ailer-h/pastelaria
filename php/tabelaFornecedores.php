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
        $tel2 = isset($_POST['tel2']) ? $tel2 = $_POST['tel2'] : null;

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "insert into fornecedores(nome,celular1,celular2,email,cnpj,descricao,ramo_atividade,produto_oferecido) values ('$nome','$tel1','$tel2','$email','$cnpj','$descricao','$ramo','$produto');");

        mysqli_close($connection);

    }

    function table($search){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select nome, celular1, celular2, cnpj, produto_oferecido, id_fornecedor from fornecedores where nome like \"%$search%\";");

        while($output = mysqli_fetch_array($query)){

            echo"<tr>";

            echo"<td>$output[0]</td>";
            echo"<td>
                <div>$output[1]</div>
                <div>$output[2]</div>
            </td>";
            echo"<td>$output[3]</td>";
            echo"<td>$output[4]</td>";
            
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

    function setForm(){
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
                            <textarea name='descricao' id='descricao' cols='30' rows='20' spellcheck='true' oninput='noBackslashes(this.value, this)' requied></textarea>
                        </div>
                    </div>
                </div>
            </form>
            </div>";
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
        
            <form action="tabelaFornecedores.php" method="post" id="searchbox">
                <input type="text" placeholder="Pesquisar..." name="search" id="searchbar">
                <input type="submit" value="🔎︎">
                <a href="tabelaFornecedores.php"><img src="../images/icons/close.png" id="close-search"></a>
            </form>

            <div id="menu">
                <button onclick=""><img src="../images/icons/report.png"></button>
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
                setForm();
            }
    
        ?>

    </div>

</body>
<script src="../js/formHandlers/handleForms_fornecedores.js"></script>
<script src="../js/masks.js"></script>
</html>