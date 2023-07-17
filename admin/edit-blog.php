<?php
$page_name = 'edit-blog';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';
require_once '../system/functions/verify-blog-info.php';



if ($id) {      // گرفتن اطلاعات فعلی بلاگ برای نمایش در فرم 
    $query = $conn->prepare("SELECT `bloginfo`.* , `userinfo`.`username` FROM `bloginfo` 
                            LEFT JOIN `userinfo` ON `userinfo`.`id` = `bloginfo`.`writer_id` LIMIT 1");

    if (!$query->execute([$id]))
        die(showAlert("danger", "مشکل در خواندن اطلاعات بلاگ موردنظر"));

    $blog = $query->fetch();
}


# Restriction For page blogs
$allowed_roles = ['manager', 'editor'];

if ($account['id'] == $blog['writer-id'])    $allowed_roles[] = 'writer';

# Which Roles can enter this page
checkRole($allowed_roles);




$id = intval(@$_REQUEST['id']);
$ref = intval(@$_REQUEST['ref']);





// var_dump($_POST);



if (isset($_POST['submitted'])) {


    $blog['title'] = @$_POST['blog-title'];
    $blog['writer_id'] = @$_POST['blog-writer'];
    $blog['description'] = @$_POST['blog-description'];
    $blog['body'] = @$_POST['blog-body'];

    // اعتبارسنجی  Validation
    #   id
    if ($id < 0)
        die(showAlert("danger", "Unexpected Error 553254545313, \n با پشتیبانی تماس بگیرید."));

    #   title
    $error_flag = !verifyTitle($blog['title'], $id);



    if (!$error_flag) {   // اگر فیلدها درست پر شده باشند 

        $editingTme = date('Y-n-j h:i:s', time());
        $query = $conn->prepare("UPDATE `bloginfo` 
                    SET `title`=?  ,`description`= ? ,`body`= ? , `update_time`= ? WHERE `id` = ?");

        $inputs = [$blog['title'], $blog['description'], $blog['body'],  $editingTme, $id];

        if (!$query->execute($inputs)) {
            $message = "خطای 46465655: \n درخواست شما با مشکل مواجه شد. با پشتیبانی تماس بگیرید. 
                        <a href='blogs-list.php?page=" . $ref . "'>بازگشت</a>";
            die(showAlert("danger", $message));
        }

        showAlert("success", "بلاگ $blog[title] با موفقیت ویرایش شد.");
    }
}



if ($id) {      // گرفتن اطلاعات فعلی بلاگ برای نمایش در فرم 
    $query = $conn->prepare("SELECT * FROM `bloginfo` WHERE `id` = ? LIMIT 1");
    if (!$query->execute([$id]))    die(showAlert("danger" , "مشکل در خواندن اطلاعات کاربر موردنظر"));
        

    if (!$blog = $query->fetch()){
        showAlert("danger" , "بلاگ موردنظر وجود ندارد.");
        echo "<a href='blogs-list.php?page=".$ref."'>بازگشت</a>";
        die();
    }

}


// نمایش فرم با اطلاعات بلاگ

require_once '../template/blog-form.php';




require_once '../template/admin-footer.php';
