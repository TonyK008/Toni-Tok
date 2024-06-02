<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("{$root}/Toni-Tok/Database.php");

$db = new Database();

require("{$root}/Toni-Tok/controllers/videoDisplayer.php");