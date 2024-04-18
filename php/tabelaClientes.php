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
            <button>Produtos</button>
            <button>Pedidos</button>
            
            <div class="user-area">
                
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
                <button onclick="setForm(0)"><img src="../images/icons/plus.png"></button>
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
    </div>

</body>
<script src="../js/formHandlers/handleForms_clientes.js"></script>
<script src="../js/masks.js"></script>
</html>