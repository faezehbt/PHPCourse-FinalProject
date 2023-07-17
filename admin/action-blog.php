<?php
$page_name = 'action';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';


# Which Roles can enter this page
checkRole(['manager','editor','writer']);



$id = intval(@$_REQUEST['id']);
$ref = intval(@$_REQUEST['ref']);


if($id)     require 'edit-blog.php';
else        require 'add-blog.php';
    