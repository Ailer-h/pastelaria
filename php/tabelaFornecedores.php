<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

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
            echo"<form action='tabelaFuncionarios.php' method='post'><input type='hidden' name='id_info' value='$output[5]'><button name='get_info' type='submit'><img src='../images/icons/info.png'></button></form>";
            echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_delete-confirmar' value='$output[5]'><button name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
            echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_edit' value='$output[5]'><button name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
            echo"</div></td></tr>";

            echo"</tr>";
            
        }

        mysqli_close($connection);

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
                <button onclick="setForm(0)"><img src="../images/icons/plus.png"></button>
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
    <div class="center-absolute">
    <div class="header">
        <h1 id="titulo-form">Novo Funcionário</h1>
        <img src="../images/icons/close.png" id="close-register" onclick="setForm(-1);">
    </div>
    <form action="tabelaFuncionarios.php" method="post">
        <div class="form-holder">
            <div class="r-one">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" oninput="noBackslashes(this.value, this) letters_js(this.value, this)" requied>
                </div>
                <div>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" maxlength="14" onkeyup="mask_js(this.value, this, '###.###.###-##')" required>
                </div>
            </div>

            <div class="r-two">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" oninput="noSlashes_js(this.value, this)" required>

                </div>
            
                <div>
                    <label for="senha">Senha:</label>
                    <input type="text" name="senha" id="senha" oninput="noSlashes_js(this.value, this)" required>
                </div>

                <div>
                    <label for="cargo">Cargo:</label>
                    <input type="text" name="cargo" id="cargo" oninput="noBackslashes(this.value, this) letters_js(this.value, this)" required>
                </div>

                <div>
                    <label for="permissoes">Permissões:</label>
                    <select name="permissoes" id="permissoes" required>
                        <option value="" selected hidden></option>
                        <option value="a">Admnistrador</option>
                        <option value="f">Funcionário</option>
                    </select>
                </div>
            </div>

            <input type="submit" name="cadastrar" id="cadastrar" value="Cadastrar">

        </div>
    </form>
</div>
    </div>

</body>
<script src="../js/formHandlers/handleForms_fornecedores.js"></script>
</html>