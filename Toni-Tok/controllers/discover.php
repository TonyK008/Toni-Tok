<?php 

if(!isset($_SESSION)){
    session_start();
}

$root = $_SERVER['DOCUMENT_ROOT'];

require_once("{$root}/Toni-Tok/Database.php");

require("{$root}/Toni-Tok/HTML/discoverPageInterface.php");