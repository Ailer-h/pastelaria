<?php

    function getTimer($end_time, $start_time){

        $tempo_preparo = abs(strtotime($end_time) - strtotime($start_time));

        $hours = floor($tempo_preparo / 3600);
        $minutes = floor(($tempo_preparo % 3600) / 60);
        $seconds = $tempo_preparo % 60;

        $timer = sprintf("%02d", $hours) . ":" .
        sprintf("%02d", $minutes) . ":" .
        sprintf("%02d", $seconds);

        $color = $tempo_preparo >= 900 ? "red" : "";

        return [$timer, $color];

    }

?>