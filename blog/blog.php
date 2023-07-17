<?php


#template
require '../template/config.php';

#system
// require '../system/functions/auto-load.php';
require_once '../system/db-connect.php';
require '../system/functions/count-table-rows.php';
require '../system/functions/photo.php';
require '../system/config.php';


$id = intval(@$_REQUEST['id']);
// $page = intval(@$_REQUEST['page']);

$query = $conn->prepare("SELECT `bloginfo`.* , `userinfo`.`username`,`userinfo`.`status` ,
                            GROUP_CONCAT(`categoryinfo`.`title` SEPARATOR ' - ' ) AS `categories-title`
                            FROM `bloginfo` 
                            LEFT JOIN `userinfo` ON `userinfo`.`id` = `bloginfo`.`writer_id`
                            LEFT JOIN `categoryinfo` ON FIND_IN_SET(`categoryinfo`.`id`,`bloginfo`.`categories`)
                            WHERE `bloginfo`.`id` = ? 
                            GROUP BY `bloginfo`.`id` LIMIT 1");

if (!$query->execute([$id]))
    die(showAlert("danger", "مشکل در خواندن اطلاعات بلاگ موردنظر"));

if ($blog = $query->fetch()) {

    $page_name = $blog['title'];

    #template
    require_once '../template/header.php';
    require_once '../template/nav.php';

    $photoName = namePhoto($blog['writer_id']);


    echo "  <h1>$blog[title]</h1>
            <h4>$blog[description]</h4>
            <h6>دسته بندی: {$blog['categories-title']}</h6>";

    if($blog['status'] == 'active')
        echo "  <h5>
                    <img src=\"/project/assets/uploads/profile-photos/$photoName?round(1000, 100000)\" onerror=\"this.onerror=null; this.src='/project/assets/uploads/profile-photos/profile.png'\" width='40' height='40' class='d-inline-block rounded-circle mx-1'/>
                        $blog[username]
                </h5>";
    
    echo "  <h6>تاریخ ایجاد: $blog[create_time]</h6>
            <h6>تاریخ آخرین تغییرات: $blog[update_time]</h6>
            <P>$blog[body]</P>
        ";

    
    

} else {
    $page_name = 'خطا!!!';

    #template
    require_once '../template/header.php';
    require_once '../template/nav.php';

    showAlert('danger', 'بلاگ موردنظر پیدا نشد.');
}
?>

<a type="button" class="btn btn-primary" href="/project/blog/">
    بازگشت
</a>


<?php

require_once '../template/footer.php';
