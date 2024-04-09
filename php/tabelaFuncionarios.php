<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";
    
    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

    //Recebe a solicitação de cadastro
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])){

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
            
            if($_SESSION['user_flag'] == "d"){

                echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
                echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_delete' value='$output[5]'><button class='button' name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
                echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_edit' value='$output[5]'><button class='button' name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
                echo"</div></td></tr>";
            
            }else{

                if($output[4] == "f"){

                    echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
                    echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_delete' value='$output[5]'><button class='button' name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>";
                    echo"<form action='tabelaEstoque.php' method='post'><input type='hidden' name='id_edit' value='$output[5]'><button class='button' name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>";
                    echo"</div></td></tr>";

                }else{

                    echo"<td><div style='display: flex; justify-content: center; gap: 1em;'>";
                    echo"<button class='disabled-button' name='delete' type='submit'><img src='../images/icons/delete.png'></button>";
                    echo"<button class='disabled-button' name='edit' type='submit'><img src='../images/icons/edit.png'></button>";
                    echo"</div></td></tr>";

                }

            }

        }

        mysqli_close($connection);
        
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
                <button onclick="setForm(0)"><img src="../images/icons/plus.png"></button>
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
    </div>

</body>
<script src="../js/handleForms_funcionarios.js"></script>
<script src="../js/masks.js"></script>

</html>