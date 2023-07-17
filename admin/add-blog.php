<?php
$page_name = 'add-blog';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';
require_once '../system/functions/verify-blog-info.php';


# Which Roles can enter this page
checkRole(['manager','editor','writer']);




$ref = intval(@$_REQUEST['ref']);


// var_dump($id);



// var_dump($_POST);

// اعتبارسنجی  Validation
 #   title
 $error_flag = !verifyTitle($blog['title'], $id);


if (isset($_POST['submitted'])) {


    $blog['title'] = @$_POST['blog-title'];
    $blog['description'] = @$_POST['blog-description'];
    $blog['body'] = @$_POST['blog-body'];

    $error_flag = 0;
    if(!$error_flag) {   // اگر همه فیلدها درست پر شده باشند 

        $creationTime = $editingTme = date('Y-n-j h:i:s' , time());

        $query = $conn->prepare("INSERT INTO    `bloginfo`
                                (`title`, `description`, `body`, `writer_id` ,`create_time`,`update_time`) 
                                VALUE (?,?,?,?,?,? )");
        $inputs = [$blog['title'] , $blog['description'] , $blog['body'] , $account['id'] , $creationTime, $editingTme];
        if (!$query->execute($inputs))
            die("اضافه کردن بلاگ با مشکل مواجه شد");

            showAlert("success" , "بلاگ با عنوان $blog[title] با موفقیت ذخیره شد.");

            $id = $conn->lastInsertId();
            $ref++;
        
    }
}




// نمایش فرم با اطلاعات کاربر

require_once '../template/blog-form.php';




require_once '../template/admin-footer.php';
