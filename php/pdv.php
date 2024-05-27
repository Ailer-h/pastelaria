<?php

    //Checa se a sessão do usuário é valida
    include "utilities/checkSession.php";

    //Função para substituir pontos por virgula em valores monetários
    include "utilities/fixMoney.php";

    //Função que recebe o id do produto desejado e checa se tem ingredientes para faze-lo
    function hasIngredients($id){
        
        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select ig.id_ingrediente, (est.qtd - ig.qtd_ingrediente) from ingredientes_prod ig, estoque est where ig.id_produto = $id and ig.id_ingrediente = est.id_item order by (est.qtd - ig.qtd_ingrediente) desc;");

        while($out = mysqli_fetch_array($query)){
            if($out[1] < 0){ mysqli_close($connection); return false; }
        }

        mysqli_close($connection);
        return true;
    }

    //Função que recebe o id do produto desejado e retorna seus ingredientes em forma de um JSON
    function getRecipe($id){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select qtd_ingrediente, id_ingrediente from ingredientes_prod where id_produto = $id;");
        $array = array();
            
        while($output = mysqli_fetch_array($query)){
            array_push($array, array($output[1] => $output[0]));
        }

        mysqli_close($connection);

        return json_encode($array);

    }

    //Função que retorna todos os elementos do estoque em forma de JSON
    function getStock(){

        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_item, qtd from estoque;");
        $array = array();

        while($output = mysqli_fetch_array($query)){
            array_push($array, array($output[0] => $output[1]));

        }

        mysqli_close($connection);
        
        return json_encode($array);

    }

    //Função que retorna todas as informações dos clientes em forma de JSON
    function getPhoneNumbers(){
        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select cli_cel, cli_nome, cli_endereco, cli_id from clientes;");
        $array = array();

        while($output = mysqli_fetch_array($query)){
            array_push($array, array($output[0] => array($output[1], $output[2], $output[3])));

        }

        mysqli_close($connection);
        
        return json_encode($array);

    }

    function showMenu(){
        include "utilities/mysql_connect.php";

        $query = mysqli_query($connection, "select id_prod, nome_prod, img_prod, valor_venda from produtos;");

        while($output = mysqli_fetch_array($query)){

            $price = fixMoney($output[3]);
            $recipe = getRecipe($output[0]);

            if(hasIngredients($output[0])){

                echo"<div><div class='item'><div class='prod'>";
                
                echo"<img src='data:image;base64,$output[2]'>";
                echo"<p id='info$output[0]'>$output[1] - R$$price</p>";
                echo"<button class='button' type='button' id='btn$output[0]' onclick='getOrder($output[0])'>Adicionar</button>";
                echo"<input type='number' value='0' name='qtd$output[0]' id='qtd$output[0]' style='display: none;'>";
                echo"<input type='hidden' name='recipe$output[0]' id='recipe$output[0]' value='$recipe'>";

                echo"</div></div></div>";
            }else{

                echo"<div><div class='item'><div class='prod'>";
                
                echo"<img src='data:image;base64,$output[2]'>";
                echo"<p id='info$output[0]'>$output[1] - R$$price</p>";
                echo"<button class='disabled-btn' type='button' id='btn$output[0]' onclick='getOrder($output[0])' disabled>Adicionar</button>";
                echo"<input type='number' name='qtd$output[0]' id='qtd$output[0]' style='display: none;' disabled>";
                echo"<input type='hidden' name='recipe$output[0]' id='recipe$output[0]' value='$recipe'>";

                echo"</div></div></div>";

            }

        }

        mysqli_close($connection);

    }

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

        header("Location: pdv.php");

    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pdv.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Novo Pedido</title>
</head>
<body>

    <div class="navbar">
        <?php
            
            if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                echo"<a href='adm_dashboard.php'>
                        <div class='logo'></div>
                    </a>";
            
            }else{
                echo"<a href='user_dashboard.php'>
                        <div class='logo'></div>
                    </a>";
            }
        
        ?>

        <h1>Novo Pedido</h1>
        
        <div class="menu">

        <?php
        
            if($_SESSION['user_flag'] != 'f' && $_SESSION['user_flag'] != 'c'){
                echo"<a href='tabelaProdutos.php'><button>Produtos</button></a>
                    <a href='cozinha.php'><button>Cozinha</button></a>
                    <a href='tabelaPedidos.php'><button>Pedidos</button></a>";
            
            }else{
                echo"<a href='cozinha.php'><button>Cozinha</button></a>
                    <a href='tabelaPedidos.php'><button>Pedidos</button></a>";

            }
        
        ?>

            <div class="user-area">
                <?php

                    $username = $_SESSION['username'];
                    echo"<p>Olá $username!</p>";

                ?>
                <a href="sessionEnded.php"><div class="logout"><img src="../images/icons/logout.png"><p>Logout</p></div></a>
            </div>
        </div>
    </div>

    <form action="recibo.php" method="post">
    <?php

        $estoque = getStock();
        $phoneNumbers = getPhoneNumbers();

        echo "<input type='hidden' id='estoque' name='estoque' value='$estoque'>";
        echo "<input type='hidden' id='phoneNumbers' name='phoneNumbers' value='$phoneNumbers'>";

    ?>
    <input type='hidden' id='array_pedidos' name='array_pedidos' value=''>

    <div class="grid">
        <div class="left">
            <div class="order-header"><h1>Pedido</h1></div>
            <div class="order-list">
                <div class="info-cliente">
                    <h3>Informações do Cliente</h3>
                    <div class="fields">
                        <label for="nome_cli">Nome:</label>
                        <input type="text" name="nome_cli" id="nome_cli" required>
                    </div>
                    <div class="fields">
                        <label for="telefone_cli">Telefone:</label>
                        <div class="searchbar">
                            <input type="text" name="telefone_cli" id="telefone_cli" onkeyup="search()" autocomplete="off" required>
                            <div id="results">
                            </div>
                        </div>
                    </div>
                    <div class="fields">
                        <label for="endereco_cli">Endereço:</label>
                        <input type="text" name="endereco_cli" id="endereco_cli" required>
                    </div>
                </div>
                <div class="pedido">
                    <table id="pedido">
                        <tr style="position: sticky; top: 0;">
                            <th style="border-left: none;">Nome</th>
                            <th>Qtd</th>
                            <th>Preço</th>
                            <th style="border-right: none; width: 3em;"></th>
                        </tr>
                    </table>
                </div>
                <p id="label-total">Total - R$0,00</p>
                <input type="hidden" name="valor-total" id="valor-total">
                <hr>
                <div class="confirmar">
                    <input type="submit" name="confirmar" id="confirmar" value="Confirmar">
                </div>
            
            </div>
        </div>

        <div class="right">
            <div class="menu-header"><h1>Menu</h1></div>
            <div class="menu">
                <div class="prod-grid">
                    <?php showMenu(); ?>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div id="form-box" style="display: none;">
        <div class='center-absolute'>
            <div class='header'>
                <h1 id='titulo-form'>Novo Cliente</h1>
                <img src='../images/icons/close.png' id='close-register' onclick='document.getElementById("form-box").style.display = "none";'>
            </div>
            <form action='pdv.php' method='post'>
                <div class='form-holder'>
                    <div class='half-1'>
                        <div class='r-one'>
                            <div>
                                <label for='nome'>Nome:</label>
                                <input type='text' name='nome' id='nome' oninput='noBackslashes(this.value, this); letters_js(this.value, this);' required>
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
                            <input type='text' name='tel' id='tel' maxlength='15' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, "(##) #####-####")' required>
                        </div>

                    </div>


                    <div class='r-three'>
                        <div>
                            <label for='cpf'>CPF:</label>
                            <input type='text' name='cpf' id='cpf' maxlength='14' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, "###.###.###-##")' required>
                        </div>
                            
                        <div>
                            <label for='rg'>RG:</label>
                            <input type='text' name='rg' id='rg' maxlength='12' oninput='noBackslashes(this.value, this); nums_js(this.value, this)' onkeyup='mask_js(this.value, this, "##.###.###-#")' required>
                        </div>
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
        </div>
    </div>

</body>
<script src="../js/masks.js"></script>
<script src="../js/pdv_controller.js"></script>
<script src="../js/searchbar_controller.js"></script>
</html>