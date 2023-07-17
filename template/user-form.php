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
                value="<?= $user['username']?>" name="username">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputEmail4">ایمیل</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="ایمیل"
                value="<?= $user['email']?>" name="email">
        </div>
        <?php
            if($page_name =='add-user'):
        ?>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputPassword">رمز عبور</label>
            <input type="password" class="form-control" id="inputPassword" placeholder="رمز عبور" name="password">
        </div>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputPasswordRepeat">تکرار رمز عبور</label>
            <input type="password" class="form-control" id="inputPasswordRepeat" placeholder="تکرار رمز عبور" name="password-repeat">
        </div>
        <?php
            endif;
        ?>
        <div class="form-group col-md-6">
            <label class="form-label" for="inputMobile4">موبایل</label>
            <input type="text" class="form-control" id="inputMobile4" placeholder="موبایل"
                value="<?=$user['mobile']? sprintf("%011d" , $user['mobile']):''?>" name="mobile">
        </div>
        <div class="d-flex col-12">
            <div class="p-1">
                <button type="submit" name="submitted" class="btn btn-primary" value="1">ذخیره</button>
            </div>
            <div class="p-1">
                <a class="btn btn-outline-primary" 
                href="users-list.php?page=<?= $ref?>">
                    بازگشت
                </a>
            </div>
            <?php
                if($page_name =='edit-user'):
            ?>
            <div class="p-1">
                <a class="btn btn-outline-danger" 
                href="delete-user.php?page=<?= $ref?>&id=<?= $id?>">
                    حذف
                </a>
            </div>  
            <?php
                endif;
            ?>       
        </div>
        
    </form>
</div>




<?php

require_once 'admin-footer.php';