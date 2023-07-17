<?php
$page_name = 'delete-blog';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
// require_once '../system/functions/auto-load.php';



$id = intval(@$_REQUEST['id']);
$ref = intval(@$_REQUEST['ref']);



$query = $conn -> prepare("SELECT * FROM `bloginfo` WHERE `id` = ? AND `status` <> 'deleted'");
if(!$query -> execute([$id]))  
    die(showAlert("danger" , "خطای 54151516515: \n درخواست شما با مشکل مواجه شد. با پشتیبانی تماس بگیرید. 
                                    <a href='blogs-list.php?page=".$ref."'>بازگشت</a>"));


if($blog = $query -> fetch()){

    
# Restriction For page users
    $allowed_roles = ['manager', 'editor'];

    if($account['id'] == $blog['writer-id'])    $allowed_roles[] = 'writer' ;

    # Which Roles can enter this page
    checkRole($allowed_roles);


    $query = $conn -> prepare("UPDATE `bloginfo` SET `status` = 'deleted' WHERE `id` = ?");
    if(!$query -> execute([$id])) 
        die(showAlert("danger" , "خطای 54151516515: \n درخواست شما با مشکل مواجه شد. با پشتیبانی تماس بگیرید. 
                                    <a href='blogs-list.php?page=".$ref."'>بازگشت</a>"));
    
    $message = "بلاگ با عنوان \"$blog[title]\" با موفقیت حذف شد. 
                <a href='blogs-list.php?page=".$ref."'>بازگشت</a>";
    showAlert('success' , $message);

}
else{
    $message = "بلاگ موردنظر وجود ندارد. مجددا تلاش کنید.  
                <a href='blogs-list.php?page=".$ref."'>بازگشت</a>";
    showAlert('danger' , $message);
}






require_once '../template/admin-footer.php';
