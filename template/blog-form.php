<?php

require_once 'admin-header.php';
require_once '../admin/action-blog.php';


?>

<div class="mx-auto">
    <form class="row g-3" action="action-blog.php?ref=<?= $ref?>" method="post">
        <input type="hidden" name="id" value="<?= $blog['id']?>">
        <div class="form-group col-md-12">
            <label class="form-label" for="inputTitle">عنوان</label>
            <input type="text" class="form-control" id="inputTitle" placeholder="عنوان" 
                value="<?= $blog['title']?>" name="blog-title" required>
        </div>
        <div class="form-group col-md-12">
            <label class="form-label" for="inputWriter">نویسنده</label>
            <input type="text" class="form-control" id="inputWriter" placeholder="نویسنده"
                value="<?= $id ? $blog['username']: $account['username']?>" name="blog-writer" disabled>
        </div>
        <div class="form-group col-md-12">
            <label class="form-label" for="inputDescription">خلاصه</label>
            <input type="text" class="form-control" id="inputDescription" placeholder="خلاصه" 
            value="<?= $blog['description']?>" name="blog-description">
        </div>
        <div class="form-group col-md-12">
            <label class="form-label" for="inputBody">متن</label>
            <textarea class="form-control" id="inputBody" placeholder="متن"
                name="blog-body"><?= $blog['body']?></textarea>
        </div>
        <div class="d-flex col-12">
            <div class="p-1">
                <button type="submit" name="submitted" class="btn btn-primary" value="1">ذخیره</button>
            </div>
            <div class="p-1">
                <a class="btn btn-outline-primary" 
                href="blogs-list.php?page=<?= $ref?>">
                    بازگشت
                </a>
            </div>
            <div class="p-1">
                <a class="btn btn-outline-danger" 
                href="delete-blog.php?page=<?= $ref?>&id=<?= $id?>">
                    حذف
                </a>
            </div>         
        </div>
        
    </form>
</div>




<?php

require_once 'admin-footer.php';