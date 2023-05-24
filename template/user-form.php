<?php

require_once 'admin-header.php';
require_once '../admin/action-user.php';


?>

<div class="mx-auto">
    <form class="row g-3" action="action-user.php?ref=<?= $ref?>" method="post">
        <input type="hidden" name="id" value="<?= $user['id']?>">
        <div class="form-group col-md-6">
            <label class="form-label" for="inputUsername4">نام کاربری</label>
            <input type="text" class="form-control" id="inputUsername4" placeholder="نام کاربری" 
                value="<?= $user['username']?>" name="username" required>
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputEmail4">ایمیل</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="ایمیل"
                value="<?= $user['email']?>" name="email">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputPassword4">رمز عبور</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="رمز عبور" name="password">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputMobile4">موبایل</label>
            <input type="text" class="form-control" id="inputMobile4" placeholder="موبایل"
                value="<?= $user['mobile']?>" name="mobile">
        </div>
        <div class="col-12">
            <button type="submit" name="submitted" class="btn btn-primary" value="1">ذخیره</button>
            <a class="btn btn-outline-primary" 
                href="users-list.php?page=<?= $ref?>">بازگشت</a>
        </div>
        
    </form>
</div>




<?php

require_once 'admin-footer.php';