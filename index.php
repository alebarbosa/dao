<?php
    require_once("config.php");
    //$list = Usuario::getList();
    //echo json_encode($list);
    //$search = Usuario::search("ale");
    //echo json_encode($search);
    //$usuario = new Usuario();
    //$usuario->login("Alexandre", "123456");
    //echo $usuario;

    $ale = new Usuario();
    $ale->insert("Ale", "abcd");
    
    ?>