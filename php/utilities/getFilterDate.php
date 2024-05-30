<?php

    date_default_timezone_set('America/Sao_Paulo');

    function getFilterDate($tag){
        $tag = strtolower($tag);
    
        if($tag == "ano"){
            $today = array_slice(explode("-", date('Y-m-d')), 1);
            return strval((int) date("Y") - 1) . "-" . implode("-", $today) . " 00:00:00";
            
        }else if($tag == "mes"){
            $today = date('Y-m');
            return $today . "-01 00:00:00";
        
        }else if($tag == "dia"){;
            return date("Y-m-d") . " 00:00:00";
        }
    
    }

?>