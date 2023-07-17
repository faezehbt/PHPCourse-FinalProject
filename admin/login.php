<?php

require_once '../system/db-connect.php';
require_once '../template/admin-header.php';

var_dump($_POST);

if (isset($_POST['username'])) {    //  درصورتی که کاربر تلاشی برای ورود کرده باشد
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    

    $query = $conn->prepare("SELECT `id` FROM `userinfo` WHERE `username` = ? AND `password` = ? LIMIT 1");
    if (!$query->execute([$username, $password]))
        die(showAlert('danger', 'درخواست شما با مشکل مواجه شد'));

    if ($account = $query->fetch()) {    //  کاربر با موفقیت وارد شد
        session_start();
        $_SESSION['account-id'] = $account['id'];
        die();
        header('Location: index.php');
        exit("  <div>
                    <p class='text-center'>لطفا کمی منتظر بمانید...</p>
                </div>");
    } else {   // نام کاربری یا رمزعبور اشتباه است و یا وجود ندارد
        showAlert('danger', 'نام کاربری یا رمز عبور اشتباه است.');
    }
}

if (isset($_GET['logout'])) {
    session_start();
    $username = $account['username'];
    session_destroy();
    showAlert('success', ".کاربر $username با موفقیت خارج شدید");
}




?>

<div class="card mx-auto mt-5 col-12 col-sm-6">
    <form class="card-body" action="login.php" method="post">
        <div>
            <label class="form-label" for="inputUsername4">نام کاربری</label>
            <input type="text" class="form-control" id="inputUsername4" placeholder="نام کاربری" value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>" name="username">
        </div>
        <div>
            <label class="form-label" for="inputPassword4">رمز عبور</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="رمز عبور" name="password">
        </div>
        <div class="m-2">
            <button type="submit" class="btn btn-primary">ورود</button>
            <a class="btn btn-outline-primary" href="sign-up.php">ثبت نام</a>
            <a class="link-primary" style="text-decoration:underline" href="/project/admin/forgot-pass.php">فراموشی رمز عبور</a>
        </div>

    </form>
</div>


<?php

require_once '../template/admin-footer.php';
