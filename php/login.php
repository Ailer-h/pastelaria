<?php

    //Detecta se o usuário está logado e passa direto pro sistema
    session_start();

    if(isset($_SESSION['user_flag'])){
        
        if($_SESSION['user_flag'] == "a" || $_SESSION['user_flag'] == "d"){
            header("Location: adm_dashboard.php");

        }else if($_SESSION['user_flag'] == "f"){
            header("Location: user_dashboard.php");

        }

    }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Login</title>
</head>

<body>
    <div class="grid">

        <!-- Form de login -->
        <form action="utilities/checkUser.php" method="post">
            <div class="form-login">
                
                <div class="icon-holder">
                    <img src="../images/icons/user.png">
                </div>
                
                <div class="aviso" id="aviso-block">
                    <div class="img-holder"><img src="../images/icons/cancel.png"></div>
                    <div class="txt-holder">
                        <p id="aviso-txt">Senha Inválida</p>
                        <p>Tente Novamente</p>
                    </div>
                </div>
                
                <h1>Login</h1>
                <label for="user">Email:</label>
                <input type="text" id="user" name="user" oninput="noSlashes_js(this.value, this)" required>
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" oninput="noSlashes_js(this.value, this)" required>
                
                <div class="passwordControl">
                    <img src="../images/icons/hide.png" id="passwordIcon" onclick="showPassword('senha', 'passwordIcon')">
                    <p>Mostrar Senha</p>
                </div>
                
                <input type="submit" value="Entrar">
            </div>
        </form>

        <!-- Banner da direita -->
        <div class="center">
            <div class="frame">
                <img src="../images/logo.png">
                <h1>PASTELARIA <br> DIVINA MASSA</h1>
            </div>
        </div>

    </div>
</body>
<script src="../js/masks.js"></script> <!-- Pacote de máscaras -->
<script src="../js/showPassword.js"></script> <!-- Função para visualizar/esconder senha -->
</html>

<!-- Recebe e trata os códigos de erro para o aviso de informação errada -->
<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['n'])){
        $error = $_POST['n'];

        echo"<script>
            console.log('Erro de Credenciais | Código = $error');
        </script>";

        if($error == 100){ //Erro de Email Inválido

            echo"<script>
                document.getElementById('aviso-block').style.display = 'block';
                document.getElementById('aviso-txt').textContent = 'Email Inválido';
            </script>";

        }else if($error == 200){ //Erro de Senha Inválida

            echo"<script>
                document.getElementById('aviso-block').style.display = 'block';
                document.getElementById('aviso-txt').textContent = 'Senha Inválida';
            </script>";
        
        }
    }
?>