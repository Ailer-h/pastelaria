<?php
    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Recebe a solicitação de cadastro
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form'])){

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
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;"><th>Nome</th><th>D. Vencimento</th><th>Custo (R$)</th><th>Uni. Medida</th><th>Qtd</th><th>Status</th><th>Ações</th></tr>
            </table>
        </div>
    </div>

    <div id="add-item">
        <div class="center-absolute">
            <div class="header">
                <h1>Nova Matéria Prima</h1>
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
                                <option value="g">G</option>
                                <option value="ml">Ml</option>
                            </select>
                        </div>

                        <div>
                            <label for="qtd">Quantidade:</label>
                            <input type="number" name="qtd" id="qtd" min="1" step="1" class="qtd" required>
                        </div>
                    </div>

                    <input type="submit" name="form" value="Cadastrar">

                </div>
            </form>
        </div>
    </div>
    
</body>
</html>