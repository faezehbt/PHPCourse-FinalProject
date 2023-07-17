<?php
require_once 'header.php';



?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php
            session_start();
            $account_id = intval(@$_SESSION['account-id']);
            ?>
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <?php
                if ($account_id) :
                ?>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/project/admin/index.php">داشبورد</a>
                    </li>
                <?php else :  ?>
                    <div class="navbar-brand d-flex">
                        <a class="btn btn-outline-secondary mr-auto  mb-2 mb-lg-0" href="/project/admin/login.php" role="button">
                            ورود/ ثبت نام
                        </a>
                    </div>
                <?php endif;  ?>
                <li class="nav-item">
                    <a class="nav-link <?= $page_name == 'بلاگ ها' ? 'active' : '' ?>" aria-current="page" href="/project/blog">
                        مطالب
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>




<?php

require_once 'footer.php';
