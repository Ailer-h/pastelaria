<?php

    if($_SESSION['user_flag'] == "f"){
        header("Location: noPermission.php");

    }

?>