<?php
$action = $_GET['action'] ?? 'index';
include_once("controller/StudentController.php");

$controller = new StudentController();

switch($action) {
    case 'api':
        $controller->api();
        break;
    case 'index':
        $controller->index();
        break;
};
?>