<!-- Conecta ao database -->
<?php

    $server = "127.0.0.1";
    $user = "root";
    $password = "";
    $database = "pastelaria";

    $connection = mysqli_connect($server,$user,$password,$database) or die ("Problemas para conectar ao banco. Verifique os dados!")

?>