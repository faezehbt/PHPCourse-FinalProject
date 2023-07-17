<?php
$page_name = 'profile';


#template
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';

#system
// require '../system/functions/auto-load.php';
require_once '../system/db-connect.php';
require '../template/config.php';
require '../system/functions/verify-user-info.php';


// var_dump($_FILES);


if (isset($_POST['submitted'])) {


    $username = @$_POST['username'];
    $email = @$_POST['email'];
    $mobile = @$_POST['mobile'];

    $photo = $_FILES['photo'];


    // بررسی و آپلود عکس پروفایل

    #   Verify Photo
    if($photo['error'] != 4 )   // یعنی کاربر عکس انتخاب کرده باشد و ورودی خالی نباشد
    {
        $error = verifyPhoto($photo); 
        if(empty($error) && !$photo['error']){  //  نبود وجود خطا در عکس
    #   Resize & Upload Photo
            $photoName = namePhoto($account_id);
            $savePath = "../assets/uploads/profile-photos/$photoName";
            $res = uploadPhoto($photo['tmp_name'] ,  $savePath);
            if($res)
                showAlert("success" , "عکس با موفقیت ذخیره شد.");
            else
                showAlert("warning", "ذخیره عکس با مشکل مواجه شد. دوباره تلاش کنید.");
            
        }
        else{
            $errors = implode("<br>" , $error);
            showAlert("primary" , "عکس شما قابل قبول نیست. موارد زیر را چک کنید:<br>"
                                . $errors);
        }
    
    }
    

    // اعتبارسنجی  Validation
    #   id
    if($account_id < 0) die(showAlert("danger" , "Unexpected Error 553254545313, \n با پشتیبانی تماس بگیرید."));

    #   username
        $error_flag = !verifyUsername($username , $account_id);
        
    #   email
        if($email)  $error_flag  = $error_flag || !verifyEmail($email);


    #   mobile 
        if($mobile)    $error_flag = $error_flag || !verifyMobile($mobile);

    
        
    if(!$error_flag){ // اگر هیچ خطایی وجود نداشته باشد اطلاعات در دیتابیس و عکس در سیستم ذخیره می شوند
        $query = $conn->prepare("UPDATE `userinfo` SET `username`=?  ,`email`= ? ,`mobile`= ? 
                                    WHERE `id` = ?");
        
        if (!$query->execute([$username , $email, $mobile, $account_id]))
            die("Unexpected Error 347682798: با پشتیبانی تماس بگیرید");
        
        showAlert("success" , "اطلاعات کاربر {$username} با موفقیت ویرایش شد.");


    }

    

}


checkLogin(); // برای اینکه اطلاعات ویرایش شده داخل فیلدها آپدیت شوند


?>


<form class="row g-3 col-12 m-auto" method="post" enctype="multipart/form-data">
    <div class="form-group col-md-6">
        <label class="form-label" for="inputUsername4">نام کاربری</label>
        <input type="text" class="form-control" id="inputUsername4" placeholder="نام کاربری" 
            value="<?= $account['username']?>" name="username">
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="inputEmail4">ایمیل</label>
        <input type="text" class="form-control" id="inputEmail4" placeholder="ایمیل"
            value="<?= $account['email']?>" name="email">
    </div>

    <div class="form-group col-md-6">
        <label class="form-label" for="inputMobile4">موبایل</label>
        <input type="text" class="form-control" id="inputMobile4" placeholder="موبایل"
            value="<?= $account['mobile']?'0'.$account['mobile']:''?>" name="mobile">
    </div>
    <div class="form-group col-md-6">
        <label class="form-label" for="inputPhoto4">عکس پروفایل</label>
        <input type="file" class="form-control" id="inputPhoto4" name="photo" accept=".jpg, .jpeg , .png , .webp , .gif">
    </div>
    <div class="col-md-6">
        <button type="submit" name="submitted" class="btn btn-primary" value="1">ذخیره</button>
    </div>
    <div class="form-group col-md-6">
    <img src="../assets/uploads/profile-photos/<?=$photoName.'?'.round(1000 , 100000)?>" 
        onerror="this.onerror=null; this.src='../assets/uploads/profile-photos/profile.png'"
        class="rounded-circle m-auto" 
        width="200" height="200" alt="عکس پروفایل">
    </div>

    
</form>
