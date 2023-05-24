<?php
$page_name = 'edit-user';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';


# Only Admin can enter this page
checkRole(['Admin']);



$id = intval(@$_REQUEST['id']);
$ref = intval(@$_REQUEST['ref']);


// var_dump($id);



// var_dump($_POST);



if (isset($_POST['submitted'])) {


    $user['username'] = @$_POST['username'];
    $user['email'] = @$_POST['email'];
    $user['password'] = @$_POST['password'];
    $user['mobile'] = @$_POST['mobile'];

// اعتبارسنجی  Validation
#   id
    if($id < 0)     
        die(showAlert("danger" , "Unexpected Error 553254545313, \n با پشتیبانی تماس بگیرید."));

#   username
    $error_flag = !verifyUsername($user['username'] , $id);
    
#   email
    if($user['email'])    $error_flag = $error_flag || !verifyEmail($user['email']);


#   mobile 
    if($user['mobile'])  $error_flag = $error_flag || !verifyMobile($user['mobile']);


    
    if(!$error_flag) {   // اگر فیلدها درست پر شده باشند 


        // آیا رمز باید تغییر کند یا خیر
        if ($user['password']) {
            $query = $conn->prepare("UPDATE `userinfo` SET `username`=:username  ,`password`= MD5(:pass) ,`email`= :email ,`mobile`= :mobile WHERE `id` = :id");
            $query->bindParam('pass', $user['password'], PDO::PARAM_STR_CHAR);
        } else
            $query = $conn->prepare("UPDATE `userinfo` SET `username`=:username  ,`email`= :email ,`mobile`= :mobile WHERE `id` = :id");

        $query->bindParam('username', $user['username'], PDO::PARAM_STR_CHAR);
        $query->bindParam('email', $user['email'], PDO::PARAM_STR_CHAR);
        $query->bindParam('mobile', $user['mobile']);
        $query->bindParam('id', $id, PDO::PARAM_INT);
    
        if (!$query->execute())
            die(showAlert("danger" , "خطای 46465655: \n درخواست شما با مشکل مواجه شد. با پشتیبانی تماس بگیرید. 
            <a href='users-list.php?page=".$ref."'>بازگشت</a>"));  

        showAlert("success" , "اطلاعات کاربر {$user['username']} با موفقیت ویرایش شد.");
        
        
        
    }
}



if ($id) {      // گرفتن اطلاعات فعلی کاربر برای نمایش در فرم 
    $query = $conn->prepare("SELECT * FROM `userinfo` WHERE `id` = ? LIMIT 1");
    if (!$query->execute([$id]))    die(showAlert("danger" , "مشکل در خواندن اطلاعات کاربر موردنظر"));
        
    $user = $query->fetch();
}

// نمایش فرم با اطلاعات کاربر

require_once '../template/user-form.php';




require_once '../template/admin-footer.php';
