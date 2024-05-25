<?php
    function getStatusClass($status){
        $status_list = [
            "Não Iniciado" => "n-iniciado",
            "Em Andamento" => "em-andamento",
            "Concluído" => "concluido",
            "Cancelado" => "cancelado",
            "Entregue" => "entregue"
        ];
        return $status_list[$status];
    }
?>