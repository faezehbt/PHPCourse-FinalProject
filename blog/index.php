<?php
$page_name = 'بلاگ ها';

#template
require_once '../template/header.php';
require_once '../template/nav.php';

#system
// require '../system/functions/auto-load.php';
require_once '../system/db-connect.php';
require '../template/config.php';
require '../system/functions/count-table-rows.php';
require '../system/functions/photo.php';





$rows_num = CountTableRows($conn, 'bloginfo'); //counting db table rows
$page_num = ceil($rows_num / BLOG_ROW_PER_PAGE);   //total page number



$page = @$_GET['page']; //this page number


// crucial condition for page number
if ($page < 1)   $page = 1;
else if ($page > $page_num)   $page = $page_num;

$start_row = ($page - 1) * BLOG_ROW_PER_PAGE;

// accessing table rows query
$res = $conn->prepare("SELECT `bloginfo`.* , `userinfo`.`username`,`userinfo`.`status`,
                        GROUP_CONCAT(`categoryinfo`.`title` SEPARATOR ' - ' ) AS `categories-title`
                        FROM `bloginfo` 
                        LEFT JOIN `userinfo` ON `userinfo`.`id` = `bloginfo`.`writer_id`
                        LEFT JOIN `categoryinfo` ON FIND_IN_SET(`categoryinfo`.`id`,`bloginfo`.`categories`)
                        WHERE `bloginfo`.`status` = 'published'
                        GROUP BY `bloginfo`.`id`;
                        -- AND `userinfo`.`status` = 'active'
                        LIMIT $start_row, " . BLOG_ROW_PER_PAGE);
if (!$res->execute())  die("خواندن اطلاعات بلاگ ها با مشکل مواجه شده");
?>

<div class="row">

  <?php
  while ($blog = $res->fetch()) {
    $photoName = namePhoto($blog['writer_id']);
  ?>


    <div class="col-lg-4 col-md-6 mb-2-6">
      <div class="card" style="height: 100%;">
        <!-- <img class="card-img-top" src="../assets/uploads/blog-photos/default.jpg" alt="Card image cap"> -->
        <div class="card-body" style="height: 100%;">
          <h5 class="card-title"><?= $blog['title'] ?></h5>
          <p class="card-text"><?= $blog['description'] ?></p>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            نویسنده:
            <img src="/project/assets/uploads/profile-photos/<?= $photoName . '?' . round(1000, 100000) ?>" onerror="this.onerror=null; this.src='/project/assets/uploads/profile-photos/profile.png'" width="40" height="40" class="d-inline-block rounded-circle mx-1" alt="" />
            <?= $blog['username'] ?>
          </li>
          <li class="list-group-item">دسته بندی: <?= $blog['categories-title'] ?></li>
          <li class="list-group-item ">تاریخ ایجاد: <?= convert_to_jalali($blog['create_time']) ?></li>
          <li class="list-group-item">تاریخ آخرین تغییر: <?= convert_to_jalali($blog['update_time']) ?></li>
        </ul>
        <div class="card-body">
          <a href="<?= $page ?>/<?= $blog['id'] ?>" class="card-link stretched-link">مشاهده</a>
        </div>
      </div>
    </div>


  <?php
  }
  ?>

</div>

<?php

require_once '../system/functions/pagination.php';
if ($page_num > 1)
  pagination($page_num, $page, 'index.php');

require_once '../template/footer.php';
