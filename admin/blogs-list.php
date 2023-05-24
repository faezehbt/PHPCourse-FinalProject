<?php
$page_name = 'blogs';


require_once '../system/db-connect.php';
require_once '../template/admin-header.php';
require '../template/config.php';
require '../system/functions/count-table-rows.php';
require_once '../template/admin-nav.php';

# 
checkRole(['Admin' , 'Writer' , 'Editor' , 'Clerk']);





$rows_num = CountTableRows($conn, 'bloginfo'); //counting db table rows
$page_num = ceil($rows_num / ROW_PER_PAGE);   //total page number



$page = @$_GET['page']; //this page number

// crucial condition for page number
if ($page < 1)   $page = 1;
else if ($page > $page_num)   $page = $page_num;

$start_row = ($page - 1) * ROW_PER_PAGE;

// accessing table rows query
$res = $conn->prepare("SELECT * FROM `bloginfo` LIMIT $start_row, " . ROW_PER_PAGE);
if (!$res->execute())  die("خواندن اطلاعات بلاگ ها با مشکل مواجه شده");

?>

<div class="d-flex my-1">
    <a type="button" class="btn btn-outline-info ms-auto" href="add-blog.php?ref=<?= $page_num ?>">
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
            echo "  <tr>
                        <td>$i</td>
                        <td>$blog[id]</td>
                        <td>{$blog['title']}</td>
                        <td>0{$blog['description']}</td>
                        <td>{$blog['writer_id']}</td>
                        <td>{$blog['create_time']}</td>
                        <td>{$blog['last_edit_time']}</td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                عملیات
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <a class=' dropdown-item' href=''>مشاهده</a>
                                    <a class=' dropdown-item' href='edit-blog.php?ref=$page&id=$blog[id]'>ویرایش</a>
                                    <a class=' dropdown-item' href='delete-blog.php?ref=$page&id=$blog[id]'>حذف</a>
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
