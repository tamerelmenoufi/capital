<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST))
    $_POST = file_get_contents('php://input');
    
    // $_POST = json_decode(file_get_contents('php://input'), true);

file_put_contents("wgw.txt", print_r($_POST, true));