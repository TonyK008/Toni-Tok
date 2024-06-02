<?php 

session_start();

$root = $_SERVER['DOCUMENT_ROOT'];

require_once("{$root}/Toni-Tok/Database.php");

require("{$root}/Toni-Tok/HTML/forYouPageInterface.php");