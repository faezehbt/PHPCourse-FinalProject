<?php

//require '../db-connect.php';


# USERNAME
function verifyUsername(string $username , int $id) : bool {
    # نام کاربری تکراری نباشد
    global $conn;
    $query = $conn -> prepare("SELECT `id` FROM `userinfo` WHERE `username` = ? AND `id` <> ?");
    if(!$query -> execute([$username , $id]))    die("Unexpected Error: 448546946584. \n با پشتیبانی تماس بگیرید.");
    if($query -> fetch()){
        showAlert("danger" , "نام کاربری $username تکراری است.");
        return false;
    }    

    # نام کاربری فرمت درستی داشته باشد
    else if(!preg_match("/^[a-z0-9\.-_]{3,32}$/is", $username)){
        showAlert("warning" , "نام کاربری باید حداقل ۳ و حداکثر ۳۲ کاراکتر(حروف کوچک و بزرگ انگلیسی، اعداد و کاراکترهای نفطه، - و ـ) باشد .");
        return false;        
    }
    else
        return true;



}


# MOBILE
function verifyMobile(string $mobile) : bool {
    if(!preg_match("/^09\d{9}$/is",$mobile)){
        showAlert("warning" , "موبایل باید به فرمت *********09 باشد.");
        return false;
    }
    else
        return true;
}


# EMAIL
function verifyEmail(string $email) : bool {
    if(!preg_match("/^[a-z0-9\.-_]{1,64}@[a-z0-9\.-]{1,253}\.\w{1,5}$/is", $email)){
        showAlert("warning" , "ایمیل اشتباه است.");
        return false;
    }
    else
        return true;

}


# PASSWORD
function verifyPassword(string $pass , string $pass_repeat) : bool {
    if($pass != $pass_repeat){
        showAlert("warning" , "رمز عبور با تکرار آن تطابق ندارد.");
        return false;
    }
    else
        return true;

}


