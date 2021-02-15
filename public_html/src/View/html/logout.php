<?php

session_start();

if(isset($_SESSION["token"])):
    unset($_SESSION["token"]);
    session_regenerate_id();
    header("Location: index.php");
else:
    header("Content-Type: application/json; charset=utf8");
    echo json_encode(array(
        "error" => "Você não está logado"
    ));
endif;