<?php
session_start();

require_once("dashboard_class.php");
require_once("../../../controllers/taskController.php");


$dash = new Dashboard();

$controller = new taskController();

$dash->init();
?>