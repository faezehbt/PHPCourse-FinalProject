<?php
$page_name = 'users';


require_once 'system/db-connect.php';
require_once 'template/admin-header.php';
require 'template/config.php';
require 'system/functions/count-table-rows.php';


$rows_num = CountTableRows($conn, 'userinfo'); //counting db user table rows
$page_num = ceil($rows_num / ROW_PER_PAGE);   //total page number



$page = @$_GET['page']; //this page number

// crucial condition for page number
if ($page < 1)   $page = 1;
else if ($page > $page_num)   $page = $page_num;

$start_row = ($page - 1) * ROW_PER_PAGE;

// accessing table rows query
$res = $conn->prepare("SELECT * FROM " . TABLE_NAME . " LIMIT $start_row, " . ROW_PER_PAGE);
if (!$res->execute())  die("خواندن اطلاعات کاربران با مشکل مواجه شده");

?>

<div class="d-flex my-1">
    <a type="button" class="btn btn-outline-info ms-auto" href="add-user.php?ref=<?= $page_num ?>">
        + کاربر جدید
    </a>
</div>

<table class="table table-striped ">
    <thead>
        <tr>
            <th>ردیف</th>
            <th>شناسه کاربری</th>
            <th>نام کاربری</th>
            <th>شماره تماس</th>
            <th>ایمیل</th>
            <th>نقش</th>
            <th>عملیات</th>
        </tr>
    </thead>

    <tbody>
        <?php

        $i = $start_row + 1; // row num(differs on each page)

        while ($user = $res->fetch()) {
            echo "  <tr>
                        <td>$i</td>
                        <td>$user[id]</td>
                        <td>{$user['username']}</td>
                        <td>0{$user['mobile']}</td>
                        <td>{$user['email']}</td>
                        <td>{$user['role']}</td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                عملیات
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <a class=' dropdown-item' href='edit-user.php?ref=$page&id=$user[id]'>ویرایش</a>
                                    <a class=' dropdown-item' href='delete-user.php?ref=$page&id=$user[id]'>حذف</a>
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

if($page_num > 1)    pagination($page_num, $page, 'users-list.php');

require_once '../template/admin-footer.php';
