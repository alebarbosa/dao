<?php
    require_once("config.php");
    //$list = Usuario::getList();
    //echo json_encode($list);
    //$search = Usuario::search("ale");
    //echo json_encode($search);
    //$usuario = new Usuario();
    //$usuario->login("Alexandre", "123456");
    //echo $usuario;

    $usuario= new Usuario();
    $usuario->loadById(25);
    $usuario->delete();
    echo $usuario;
    
    
    
    ?>