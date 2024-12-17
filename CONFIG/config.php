<?php
   include_once "./classes/Database.php"; 
   date_default_timezone_set('America/Sao_Paulo');
   $database = new Database(); 
   $db = $database->getConnection();

?> 
