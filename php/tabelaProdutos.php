<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";
    
    //Checa se o usuário tem permissões para entrar na pagina
    include "utilities/checkPermissions.php";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabelaProdutos.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Produtos</title>
</head>
<body>

    <div class="navbar">
        <a href="adm_dashboard.php">
            <div class="logo"></div>
        </a>

        <h1>Produtos</h1>
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
                <th style="border-left: none;">Nome</th>
                <th>Ingredientes</th>
                <th>Preço</th>
                <th style="border-right: none;">Valor de Venda</th>

            </table>
        </div>
    </div>

    <div id="form-box">
    <div class='center-absolute'>
                <div class='header'>
                    <h1 id='titulo-form'>Novo Produto</h1>
                    <img src='../images/icons/close.png' id='close-register' onclick='location.href = location.href'>
                </div>
                <form action='tabelaProdutos.php' method='post'>
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
                                <input type='number' name='qtd' id='qtd' min='0' step='1' class='qtd' required>
                            </div>

                            <div>
                                <label for='qtd'>Qtd Padrão:</label>
                                <input type='number' name='qtd-controle' id='qtd-controle' min='0' step='1' class='qtd' required>
                            </div>
                        </div>

                        <input type='submit' name='cadastrar' id='cadastrar' value='Cadastrar'>

                    </div>
                </form>
            </div>
    </div>

</body>
<script src="../js/masks.js"></script> <!-- Pacote de máscaras -->
</html>