<?php

function login($username){
    session_start();

    $_SESSION['user'] = [
        'username' => $username
    ];
    
    header('location: /Toni-Tok/');
    exit();
}