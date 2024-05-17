<?php
    include "utilities/checkSession.php";
    include "utilities/checkPermissions.php";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adm_dashboard.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Dashboard</title>
</head>
<body>
    <!-- Barra de navegção -->
    <div class="navbar">
        <div class="logo"></div>
        <div class="menu">
            
            <div class="user-area">
                
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";
                
                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"> <p>Logout</p></div></a>
            </div>
        </div>
    </div>

    <!-- Dashboard de páginas -->
    <div class="center">
        <div class="grid">
            <div class="item">
                <h1>Produtos</h1>
                    <a href="tabelaProdutos.php"><button>Ver produtos</button></a>
            </div>

            <div class="item">
                <h1>Estoque</h1>
                    <a href="tabelaEstoque.php"><button>Ver estoque</button></a>
            </div>

            <div class="item">
                <h1>Pedidos</h1>
                    <a><button>Ver pedidos</button></a>
            </div>

            <div class="item">
                <h1>Clientes</h1>
                    <a href="tabelaClientes.php"><button>Ver clientes</button></a>
            </div>

            <div class="item">
                <h1>Fornecedores</h1>
                    <a href="tabelaFornecedores.php"><button>Ver fornecedores</button></a>
            </div>

            <div class="item">
                <h1>Funcionários</h1>
                    <a href="tabelaFuncionarios.php"><button>Ver funcionarios</button></a>
            </div>
        </div>
    </div>

</body>
</html>