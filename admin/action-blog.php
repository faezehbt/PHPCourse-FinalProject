<?php
$page_name = 'action';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';


# Only Admin can enter this page
checkRole(['Admin']);



$id = intval(@$_REQUEST['id']);
$ref = intval(@$_REQUEST['ref']);


if($id)     require 'edit-user.php';
else require 'add-user.php';