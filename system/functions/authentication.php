<?php

// کاربر وارد شده و وجود دارد
function checkLogin(){
    global $conn, $account , $account_id;

    session_start();
    $account_id = intval(@$_SESSION['account-id']);
    if (!$account_id) {
        header('Location: ../admin/login.php');
        die();
    }
    
    $query = $conn->prepare("SELECT * FROM `userinfo` WHERE `id` = ? LIMIT 1");
    if (!$query->execute([$account_id]))      die("Unexpected Error 400073678");
    if (!$account = $query->fetch()) {
        session_destroy();
        header('Location: ../admin/login.php');
        die("خروج از پنل کاربری");
    }
    
}




// دسترسی به صفحات چک شود 
function checkRole(array $allowedRoles){
    global $account;
    if(!in_array($account['role'] , $allowedRoles))
        die(showAlert("danger" , "شما به این صفحه دسترسی ندارید. " .
                                    "<a href='/project/admin/'>بازگشت</a>"));
}