<?php

//require '../db-connect.php';


# USERNAME
function verifyTitle(string $title , int $id) : bool {
    # نام کاربری تکراری نباشد
    global $conn;
    $query = $conn -> prepare("SELECT `id` FROM `bloginfo` WHERE `title` = ? AND `id` <> ?");
    if(!$query -> execute([$title , $id]))    die("Unexpected Error: 448546946584. \n با پشتیبانی تماس بگیرید.");
    if($query -> fetch()){
        showAlert("danger" , "نام کاربری $title تکراری است.");
        return false;
    }    
    # عنوان فرمت درستی داشته باشد
    else if(!preg_match("/^.{3,256}$/is", $title)){
        showAlert("warning" , "عنوان مورد نظر طول مناسبی ندارد.");
        return false;        
    }
    else
        return true;



}


# DESCRIPTION
function verifyDescription(string $description)  {
    
}


# BODY
function verifyBody(string $email)  {
   
}

