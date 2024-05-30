<?php

    function getFilterTags($timestamp){

        $tags = "";

        $arrayDate = explode("-", explode(" ", $timestamp)[0]);
        $date = explode("-", date("Y-m-d"));

        //Da as tags de dia/mes/ano para o filtro
        if($arrayDate[0] == $date[0] && $arrayDate[1] == $date[1] && $arrayDate[2] == $date[2]){
            $tags = $tags."dia;";

        }

        if($arrayDate[0] == $date[0] && $arrayDate[1] == $date[1]){
            $tags = $tags."mes;";

        }

        if($arrayDate[0] == $date[0]){
            $tags = $tags."ano;";

        }

        return $tags;

    }

?>