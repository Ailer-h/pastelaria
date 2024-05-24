<?php
    function fixMoney($value){
        return str_replace(".", ",", sprintf("%1$.2f", $value));
    }
?>