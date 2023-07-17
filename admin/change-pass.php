<?php
$page_name = 'change-pass';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require_once '../template/admin-nav.php';
require_once '../system/functions/authentication.php';
require_once '../system/functions/verify-user-info.php';


# Which Roles can enter this page
checkRole(['manager','editor','writer','user']);





if (isset($_POST['submitted'])) {

    $pass = @$_POST['password'];
    $pass_repeat = @$_POST['password-repeat'];

    // اعتبارسنجی  Validation

    #   id
    if ($id < 0)
        die(showAlert("danger", "Unexpected Error 553254545313, \n با پشتیبانی تماس بگیرید."));

    $query = $conn->prepare("SELECT `username` FROM `userinfo` WHERE `id` = ? LIMIT 1");
    if (!$query->execute([$account['id']]))
        die(showAlert("danger", "مشکل در خواندن اطلاعات کاربر موردنظر"));
    if (!$user = $query->fetch()) {
        showAlert("danger", "کاربر موردنظر وجود ندارد.");
        $error_flag = 1;
    }

    #   password
    $error_flag = $error_flag || !verifyPassword($pass, $pass_repeat);


    if (!$error_flag) {

        $query = $conn->prepare("UPDATE `userinfo` SET `password`= MD5(?) WHERE `id` = ?");

        if (!$query->execute([$pass, $account['id']]))
            die("تغییر رمز با مشکل مواجه شد");

        showAlert("success", "رمز جدبد برای کاربر {$user['username']} با موفقیت ذخیره شد.");

        $id = $conn->lastInsertId();
        $ref++;
    }
}

?>
<div class="container me-2">
    <div class="mx-auto">
        <form action="change-pass.php" method="post">
            <div class="row g-3">
                <div class="form-group col-md-6">
                    <label class="form-label" for="inputPassword">رمز عبور</label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="رمز عبور" name="password">
                </div>
            </div>
            <div class="row g-3">
                <div class="form-group col-md-6">
                    <label class="form-label" for="inputPasswordRepeat">تکرار رمز عبور</label>
                    <input type="password" class="form-control" id="inputPasswordRepeat" placeholder="تکرار رمز عبور" name="password-repeat">
                </div>
            </div>
            <div class="d-flex col-12">
                <div class="p-1">
                    <button type="submit" name="submitted" class="btn btn-primary" value="1">ذخیره</button>
                </div>
            </div>
        </form>
    </div>

</div>

<?php

require_once '../template/admin-footer.php';
