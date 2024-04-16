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

        <h1>Estoque</h1>
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
                    <th>Celulares</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>CNPJ</th>
                    <th>Ramo de Atividade</th>
                    <th>Produto Oferecido</th>
                    <th style="border-right: none;">Ações</th>
                </tr>
                
                <tr style="position: sticky; top: 0; background-color: #dcdcdc;">
                    <td style="border-left: none;">Fornecedor</td>
                    <td><div>12345678901234</div><div>12345678901234</div></td>
                    <td>fornec@email.com</td>
                    <td>Rua dos Bobos Nº0</td>
                    <td>00. 000. 000/0001-00</td>
                    <td>Carnes</td>
                    <td>Calabresa</td>
                    <td style="border-right: none;">
                        <div style='display: flex; justify-content: center; gap: 1em;'>
                            <button class='button'><img src='../images/icons/info.png'></button>
                            <form action='tabelaFuncionarios.php' method='post'><input type='hidden' name='id_delete-confirmar' value='1'><button class='button' name='delete' type='submit'><img src='../images/icons/delete.png'></button></form>
                            <form action='tabelaFuncionarios.php' method='post'><input type='hidden' name='id_edit' value='1'><button class='button' name='edit' type='submit'><img src='../images/icons/edit.png'></button></form>
                        </div>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    <div id="form-box">
    </div>

</body>
<script src="../js/formHandlers/handleForms_estoque.js"></script>
</html>