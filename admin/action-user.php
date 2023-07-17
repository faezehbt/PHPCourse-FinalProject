<?php
$page_name = 'action-user';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';


# Which Roles can enter this page
checkRole(['manager','editor']);




$id = intval(@$_REQUEST['id']);
$ref = intval(@$_REQUEST['ref']);


if($id)     require 'edit-user.php';
else require 'add-user.php';