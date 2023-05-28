<?php
$dbhost='localhost';
$dbuser='root';
$dbpaswoord='';
$dbdatabase='msdatabase';
$db = new mysqli($dbhost, $dbuser, $dbpaswoord, $dbdatabase);
$db->query("SET character_set_results=utf8");
 ?>