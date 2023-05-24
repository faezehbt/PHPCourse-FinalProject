<?php
$page_name = 'add-user';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';


# Only Admin can enter this page
checkRole(['Admin']);



$ref = intval(@$_REQUEST['ref']);


// var_dump($id);



// var_dump($_POST);



if (isset($_POST['submitted'])) {


    $user['username'] = @$_POST['username'];
    $user['email'] = @$_POST['email'];
    $user['password'] = md5(@$_POST['password']);
    $user['mobile'] = @$_POST['mobile'];

// اعتبارسنجی  Validation
#   id
    if($id < 0) die(showAlert("danger" , "Unexpected Error 553254545313, \n با پشتیبانی تماس بگیرید."));

#   username
    $error_flag = !verifyUsername($user['username'] , 0);
    
#   email
    if($user['email'])      $error_flag = $error_flag || !verifyEmail($user['email']);


#   mobile 
    if($user['mobile'])      $error_flag = $error_flag || !verifyMobile($user['mobile']);


    
    if(!$error_flag) {   // اگر همه فیلدها درست پر شده باشند 

        $query = $conn->prepare("INSERT INTO `userinfo`(`username`, `password`, `email`, `mobile`) 
                VALUE (:username,:pass,:email,:mobile )");
            $query->bindParam('username', $user['username'], PDO::PARAM_STR_CHAR);
            $query->bindParam('pass', $user['password'], PDO::PARAM_STR_CHAR);
            $query->bindParam('email', $user['email'], PDO::PARAM_STR_CHAR);
            $query->bindParam('mobile', $user['mobile']);


            if (!$query->execute())
                die("اضافه کردن کاربر جدید با مشکل مواجه شد");

            showAlert("success" , "اطلاعات کاربر {$user['username']} با موفقیت ذخیره شد.");

            $id = $conn->lastInsertId();
            $ref++;
        
    }
}




// نمایش فرم با اطلاعات کاربر

require_once '../template/user-form.php';




require_once '../template/admin-footer.php';
