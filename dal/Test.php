<?php
include 'Config.php';
include 'Database.php';

$db = new Database();

$db->beginTransaction();
$db->query("insert into cargo (nombre)values (:nombre)");
$db->bind(":nombre", "delantero");

$db->execute();
$lastId = $db->lastInsertId();
echo ($lastId);

$db->query("insert into persona (nombre,idcargo)values (:nombre,:idcargo)");
$db->bind(":nombre", "carlos");
$db->bind(":idcargo", $lastId);

$db->execute();

$db->endTransaction();





