<?php

require './App/Classes/Usuario.php';

if(isset($_GET['id_user'])){

    $id = $_GET['id_user'];
    $objUser = new Usuario();
    $user_delete = $objUser->buscar_por_id($id);

    $del = $user_delete->excluir();
    if($del){      
        header('location: ./listar.php');
    }
}