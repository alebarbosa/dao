<?php
    require_once("config.php");
    $ale = new Usuario();
    $ale->loadById(4); 

    echo $ale;
    ?>
