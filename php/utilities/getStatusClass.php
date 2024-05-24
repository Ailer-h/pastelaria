<?php
    function getStatusClass($status){
        $status_list = [
            "Não Iniciado" => "n-iniciado",
            "Em Andamento" => "em-andamento",
            "Feito" => "feito",
            "Cancelado" => "cancelado"
        ];
        return $status_list[$status];
    }
?>