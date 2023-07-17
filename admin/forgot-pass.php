<?php
$page_name = 'forgot-pass';

require_once '../template/admin-header.php';

require_once '../system/db-connect.php';
require_once '../system/functions/password.php';


if (isset($_POST['submitted'])) {

    $email = trim(@$_POST['email']);

    // اعتبارسنجی  Validation


    $query = $conn->prepare("SELECT * FROM `userinfo` WHERE `email` = ? LIMIT 1");

    if (!$query->execute([$email]))
        die(showAlert("danger", "مشکل در خواندن اطلاعات کاربر موردنظر"));

    if (!$user = $query->fetch()) {// چک شود آیا کاربر وجود دارد یا خیر
        $error_flag = 1;
    }
    


    if (!$error_flag) {

        $newPass = randomPassword();
        echo $newPass;

        $query = $conn->prepare("UPDATE `userinfo` SET `password`= MD5(?) WHERE `id` = ?");

        if (!$query->execute([$newPass, $user['id']]))
            die("عملیات موردنظر با مشکل مواجه شد");

        

        $message = "درصورت اطمینان از ایمیل خود، آن را برای بدست آوردن رمز جدید چک کنید. <a href='login.php'>ورود</a>";
        die(showAlert("success", $message));

    }
}

?>
<div class="container me-2">
    <div class="mx-auto">
        <form action="forgot-pass.php" method="post">
            <div class="form-group col-md-6">
                <label class="form-label" for="inputEmail4">ایمیل خود را وارد کنید</label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="ایمیل"
                    value="<?= @$_POST['email']?>" name="email">
            </div>
            <div class="d-flex col-12">
                <div class="p-1">
                    <button type="submit" name="submitted" class="btn btn-primary" value="1">بازیابی</button>
                </div>
            </div>
        </form>
    </div>

</div>

<?php

require_once '../template/admin-footer.php';
