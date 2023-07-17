<?php
$page_name = 'sign-up';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../system/functions/verify-user-info.php';





// var_dump($_POST);



if (isset($_POST['submitted'])) {


    $user['username'] = @$_POST['username'];
    $user['email'] = @$_POST['email'];
    $pass = @$_POST['password'];
    $pass_repeat = @$_POST['password-repeat'];
    $user['mobile'] = @$_POST['mobile'];

// اعتبارسنجی  Validation

#   password
    if(!($error_flag = !verifyPassword($pass , $pass_repeat)))
        $user['password'] = md5($pass);  

#   username
    $error_flag = $error_flag || !verifyUsername($user['username'] , 0);
    
#   email
    if($user['email'])      
        $error_flag = $error_flag || !verifyEmail($user['email']);

#   mobile 
    if($user['mobile'])     
        $error_flag = $error_flag || !verifyMobile($user['mobile']);


    
    if(!$error_flag) {   // اگر همه فیلدها درست پر شده باشند 

        $query = $conn->prepare("INSERT INTO `userinfo`(`username`, `password`, `email`, `mobile`) 
                                VALUE (?,?,?,? )");
           
        if (!$query->execute([$user['username'],$user['password'],$user['email'],$user['mobile']]))
            die("اضافه کردن کاربر جدید با مشکل مواجه شد");

        $message = "کاربر {$user['username']} با موفقیت ثبت نام شد.<br>";
        showAlert("success" , $message);
        echo "<a class='btn btn-outline-primary' 
                href='login.php'>
                    ورود
                </a>";
        die();


    }
}



?>

<div class="mx-auto">
    <form class="row g-3" action="sign-up.php" method="post">
        <div class="form-group col-md-6">
            <label class="form-label" for="inputUsername4">نام کاربری</label>
            <input type="text" class="form-control" id="inputUsername4" placeholder="نام کاربری" 
                value="<?= $user['username']?>" name="username">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputEmail4">ایمیل</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="ایمیل"
                value="<?= $user['email']?>" name="email">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputPassword">رمز عبور</label>
            <input type="password" class="form-control" id="inputPassword" placeholder="رمز عبور" name="password">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputPasswordRepeat">تکرار رمز عبور</label>
            <input type="password" class="form-control" id="inputPasswordRepeat" placeholder="تکرار رمز عبور" name="password-repeat">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputMobile4">موبایل</label>
            <input type="text" class="form-control" id="inputMobile4" placeholder="موبایل"
                value="<?=$user['mobile']? sprintf("%011d" , $user['mobile']):''?>" name="mobile">
        </div>
        <div class="d-flex col-12">
            <div class="p-1">
                <button type="submit" name="submitted" class="btn btn-primary" value="1">ثبت نام</button>
            </div>
            <div class="p-1">
                <a class="btn btn-outline-primary" 
                href="login.php">
                    ورود
                </a>
            </div>     
        </div>
        
    </form>
</div>






<?php

require_once '../template/admin-footer.php';
