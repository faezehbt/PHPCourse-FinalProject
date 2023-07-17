<?php
$page_name = 'blogs';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require '../template/config.php';
require '../system/functions/count-table-rows.php';
require_once '../template/admin-nav.php';

# Which Roles can enter this page
checkRole(['manager','editor','writer']);





$rows_num = CountTableRows($conn, 'bloginfo'); //counting db table rows
$page_num = ceil($rows_num / BLOG_ROW_PER_PAGE);   //total page number



$page = @$_GET['page']; //this page number

// crucial condition for page number
if ($page < 1)   $page = 1;
else if ($page > $page_num)   $page = $page_num;

$start_row = ($page - 1) * BLOG_ROW_PER_PAGE;

// accessing table rows query
$res = $conn->prepare("SELECT `bloginfo`.* , `userinfo`.`username` FROM `bloginfo` 
                        LEFT JOIN `userinfo` ON `userinfo`.`id` = `bloginfo`.`writer_id`
                        WHERE `bloginfo`.`status` <> 'deleted'
                        LIMIT $start_row, " . BLOG_ROW_PER_PAGE);
if (!$res->execute())  die("خواندن اطلاعات بلاگ ها با مشکل مواجه شده");

?>

<div class="d-flex my-1">
    <a type="button" class="btn btn-outline-info ms-auto" href="add-blog.php?ref=<?= $page ?>">
        + ایجاد بلاگ
    </a>
</div>

<table class="table table-striped ">
    <thead>
        <tr>
            <th>ردیف</th>
            <th>شناسه بلاگ</th>
            <th>عنوان</th>
            <th>خلاصه</th>
            <th>نویسنده</th>
            <th>تاریخ ایجاد</th>
            <th>تاریخ آخرین تغییر</th>
            <th>عملیات</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i = $start_row + 1; // row num(differs on each page)

        while ($blog = $res->fetch()) {
            $color = $blog['status'] == 'published'?'success':'warning';
            $create_time = convert_to_jalali($blog['create_time']);
            $update_time = convert_to_jalali($blog['update_time']);

            echo "  <tr class=\"table-$color\">
                        <td>$i</td>
                        <td>$blog[id]</td>
                        <td>$blog[title]</td>
                        <td>$blog[description]</td>
                        <td>$blog[username]</td>
                        <td>$create_time</td>
                        <td>$update_time</td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton'        data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    عملیات  
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <a class='dropdown-item' href='#'>مشاهده</a>
                                <a class='dropdown-item' href='edit-blog.php?ref=$page&id=$blog[id]'>ویرایش</a>
                                <hr class='dropdown-divider'>
                                <a class='dropdown-item link-danger' href='delete-blog.php?ref=$page&id=$blog[id]'>حذف</a>
                                </div>
                            </div>
                        </td>
                    </tr>";
            $i++;
        }


        ?>

    </tbody>
</table>


<?php

require_once '../system/functions/pagination.php';
if($page_num > 1)    pagination($page_num, $page, 'blogs-list.php');

require_once '../template/admin-footer.php';
