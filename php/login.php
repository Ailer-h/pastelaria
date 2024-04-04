<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="grid">
        <div class="login">
            <form action="checkUser.php" method="post">
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
                    
                    <input type="submit" value="Entrar">
                </div>
            </form>
        </div>

        <div class="center">
            <div class="frame">
                <h1>PASTELARIA NOME</h1>
            </div>
        </div>

    </div>
</body>
<script src="../js/masks.js"></script>
</html>

<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['n'])){
        $error = $_POST['n'];

        echo"<script>
            console.log('Erro de Email | Código = $error');
        </script>";

        if($error == 100){

            echo"<script>
                document.getElementById('aviso-block').style.display = 'block';
                document.getElementById('aviso-txt').textContent = 'Email Inválido';
            </script>";

        }else if($error == 200){

            echo"<script>
                document.getElementById('aviso-block').style.display = 'block';
                document.getElementById('aviso-txt').textContent = 'Senha Inválida';
            </script>";
        
        }
    }
?>